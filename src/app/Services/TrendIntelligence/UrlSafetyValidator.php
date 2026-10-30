<?php

namespace App\Services\TrendIntelligence;

use InvalidArgumentException;

class UrlSafetyValidator
{
    /**
     * Validate an external URL for safe outbound HTTP fetching (SSRF prevention).
     *
     * @throws InvalidArgumentException
     */
    public function assertSafeForFetch(string $url, bool $resolveDns = false): string
    {
        $url = trim($url);
        if ($url === '' || strlen($url) > 1000) {
            throw new InvalidArgumentException('URL is empty or exceeds maximum length.');
        }

        $parts = parse_url($url);
        if ($parts === false || empty($parts['scheme']) || empty($parts['host'])) {
            throw new InvalidArgumentException('Malformed URL structure.');
        }

        $scheme = strtolower($parts['scheme']);
        if (!in_array($scheme, ['https', 'http'], true)) {
            throw new InvalidArgumentException("Disallowed URL scheme '{$scheme}'. Only HTTP/HTTPS are permitted.");
        }

        if (!empty($parts['user']) || !empty($parts['pass'])) {
            throw new InvalidArgumentException('URLs containing embedded credentials are not permitted.');
        }

        if (!empty($parts['port']) && !in_array((int) $parts['port'], [80, 443], true)) {
            throw new InvalidArgumentException('Non-standard network ports are not permitted.');
        }

        $host = strtolower(trim($parts['host'], '[]'));

        $this->assertSafeHostname($host);

        // If host is an IP literal, validate that it is a public routable IP
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $this->assertPublicIp($host);
        } elseif ($resolveDns) {
            $ips = @gethostbynamel($host);
            if (is_array($ips)) {
                foreach ($ips as $ip) {
                    $this->assertPublicIp($ip);
                }
            }
        }

        return $url;
    }

    /**
     * Validate a citation/evidence URL before storing or displaying on public pages.
     */
    public function isSafeCitationUrl(?string $url): bool
    {
        if ($url === null || trim($url) === '') {
            return false;
        }

        try {
            $this->assertSafeForFetch($url, false);
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Reject local, internal, or metadata hostnames.
     */
    protected function assertSafeHostname(string $host): void
    {
        $blockedHosts = [
            'localhost',
            'localhost.localdomain',
            'ip6-localhost',
            'ip6-loopback',
            'metadata.google.internal',
            'metadata',
            'instance-data',
        ];

        if (in_array($host, $blockedHosts, true)) {
            throw new InvalidArgumentException("Host '{$host}' is blocked by SSRF policy.");
        }

        $blockedSuffixes = ['.local', '.internal', '.localhost', '.lan', '.home', '.corp', '.intranet'];
        foreach ($blockedSuffixes as $suffix) {
            if (str_ends_with($host, $suffix)) {
                throw new InvalidArgumentException("Internal hostname suffix '{$suffix}' is blocked by SSRF policy.");
            }
        }
    }

    /**
     * Reject private, loopback, link-local, and reserved IPv4/IPv6 addresses.
     */
    protected function assertPublicIp(string $ip): void
    {
        $isPublic = filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );

        if ($isPublic === false) {
            throw new InvalidArgumentException("IP address '{$ip}' is in a private, loopback, or reserved range (SSRF blocked).");
        }
    }
}

