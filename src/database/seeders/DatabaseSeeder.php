<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\TransactionCategory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@sigmaticsoft.com'],
            [
                'name' => 'Sigmatic Soft Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Seed Default Accounts
        $accounts = [
            ['name' => 'Cash', 'type' => 'cash', 'opening_balance' => 5000.00],
            ['name' => 'Bank Account', 'type' => 'bank', 'opening_balance' => 50000.00],
            ['name' => 'bKash Merchant', 'type' => 'mobile_wallet', 'opening_balance' => 10000.00],
            ['name' => 'Nagad', 'type' => 'mobile_wallet', 'opening_balance' => 5000.00],
        ];

        foreach ($accounts as $acc) {
            Account::updateOrCreate(['name' => $acc['name']], $acc);
        }

        // 3. Seed Transaction Categories
        $incomeCategories = ['Client Payment', 'Service Income', 'Other Income'];
        $expenseCategories = [
            'Server', 'Hosting', 'Domain', 'Software', 'Salary', 
            'Marketing', 'Office', 'Transportation', 'Internet', 
            'Utilities', 'Other'
        ];

        foreach ($incomeCategories as $cat) {
            TransactionCategory::updateOrCreate(
                ['name' => $cat, 'type' => 'income'],
                ['status' => 'active']
            );
        }

        foreach ($expenseCategories as $cat) {
            TransactionCategory::updateOrCreate(
                ['name' => $cat, 'type' => 'expense'],
                ['status' => 'active']
            );
        }

        // 4. Seed Portfolios
        $portfolios = [
            [
                'name' => 'Multi-Vendor E-Commerce Platform',
                'description' => 'A fully custom enterprise-level marketplace featuring automated invoicing, real-time logistics tracking, and localized bKash/Nagad checkout gateways.',
                'image' => null,
                'is_active' => 1
            ],
            [
                'name' => 'Sigmatic School ERP Portal',
                'description' => 'An all-in-one educational platform automating student admissions, custom course grading sheets, dynamic schedules, and parent billing ledgers.',
                'image' => null,
                'is_active' => 1
            ],
            [
                'name' => 'Diagnostics & Telemedicine System',
                'description' => 'A secure healthcare application facilitating video consultations, dynamic prescription generation, patient health record vaults, and automated clinic appointments.',
                'image' => null,
                'is_active' => 1
            ],
        ];

        foreach ($portfolios as $port) {
            \App\Models\portfolio::updateOrCreate(['name' => $port['name']], $port);
        }

        // 5. Seed Insights/Blog
        $insights = [
            [
                'title' => '5 Digitization Strategies for Retail SMBs in Bangladesh',
                'excerpt' => 'A complete roadmap for offline retail businesses to transition to automated inventory, web ordering, and mobile wallet payments.',
                'content' => '<p>In today\'s fast-paced digital economy, offline retail businesses are facing unprecedented challenges. Traditional operations with manual ledger logging, offline invoicing, and physical cash counting are not only slow but error-prone. Modernization is no longer a luxury—it is an operational survival strategy.</p><h4>1. Automated Mobile Ledger Integration</h4><p>Instead of manual calculations, integrating SMS-notified mobile ledgers like bKash/Nagad simplifies payment processing and daily audits.</p><h4>2. Single-Page Web Invoicing</h4><p>Customers want quick, shareable PDF invoices. Adopting a simple web invoicing tool speeds up checkout cycles by 40%.</p><h4>3. Unified Inventory Databases</h4><p>Stock updates should automatically alert the billing terminal, reducing overselling incidents.</p>',
                'meta_title' => 'Digitization Strategies for Retail SMBs | SigmaticSoft',
                'meta_description' => 'Explore the blueprint for offline retail companies in Bangladesh to automate billing, payments, and inventory scaling.',
                'meta_keywords' => 'smb digitization, retail software, billing automation, bkash nagad business',
            ],
            [
                'title' => 'Why Developing a Minimum Viable Product (MVP) is Key to Startup Success',
                'excerpt' => 'How launching an MVP helps early-stage startups test hypotheses, collect feedback, and secure funding without over-engineering.',
                'content' => '<p>Over 90% of early-stage startups fail, and the number one reason is building products that nobody wants. Founders often spend months or years developing complex software only to find out there is no product-market fit. MVP development offers a smart, lean alternative.</p><h4>Validate with Real Users</h4><p>By building a core set of features, you get your product into the hands of real users as fast as possible to collect actionable usability metrics.</p><h4>Save Development Costs</h4><p>Focusing purely on primary workflows saves critical budget for marketing and post-launch iterations.</p>',
                'meta_title' => 'Why Launching an MVP is Crucial for Startups | SigmaticSoft',
                'meta_description' => 'Discover how Minimum Viable Products help validate business hypotheses and secure funding with minimal initial development budgets.',
                'meta_keywords' => 'mvp development, startup guide, agile product launch, lean engineering',
            ],
            [
                'title' => 'How to Modernize a Legacy Laravel Application',
                'excerpt' => 'A practical guide to upgrading, refactoring, and optimizing legacy Laravel applications to improve reliability, security, and scalability.',
                'content' => '<h4>The Cost of PHP & Laravel Technical Debt</h4><p>Laravel applications that were built years ago often become heavy anchors holding businesses back. Outdated framework versions (like Laravel 5 or 6), insecure PHP versions, slow queries, and missing tests prevent teams from releasing new features quickly.</p><h4>1. Incremental Upgrades Over Full Rewrites</h4><p>Never rewrite from scratch unless absolutely necessary. Upgrading Laravel step-by-step (e.g., v6 -> v7 -> v8 -> v9 -> v10) using tools like Laravel Shift is safer and preserves operational integrity.</p><h4>2. Establishing Automated Testing</h4><p>Before refactoring any core business logic, write integration tests for critical user flows to ensure no regression occurs during modernization.</p>',
                'meta_title' => 'How to Modernize Legacy Laravel Applications | Sigmatic Soft',
                'meta_description' => 'Step-by-step engineering strategies for upgrading old Laravel applications, reducing technical debt, and improving cloud performance.',
                'meta_keywords' => 'Modernization, Laravel modernization, legacy code refactoring, Laravel upgrade, technical debt PHP',
            ],
            [
                'title' => 'Rewrite vs Modernize: Which Should Your Business Choose?',
                'excerpt' => 'Compare the risks, costs, and timeline of refactoring legacy systems incrementally versus undertaking a complete software rewrite.',
                'content' => '<h4>The Temptation of the Clean Slate</h4><p>When software becomes slow and full of bugs, the immediate reaction of many engineering teams is to suggest a complete rewrite. However, industry data shows that over 70% of software rewrite projects fail, run over budget, or get abandoned.</p><h4>1. The Real Cost of a Full Rewrite</h4><p>A rewrite means building a second system from scratch while maintaining the first. It doubles operational overhead and delays critical business updates for months or years.</p><h4>2. The Power of Incremental Modernization</h4><p>Modernization improves existing systems piece by piece. Extracting APIs, optimizing database schemas, and rewriting legacy code paths incrementally keeps your business running smoothly without downtime.</p>',
                'meta_title' => 'Software Rewrite vs Legacy Modernization | Sigmatic Soft',
                'meta_description' => 'An executive guide comparing software rewrite costs against incremental legacy modernization strategies for SMEs.',
                'meta_keywords' => 'Modernization, legacy modernization vs rewrite, software refactoring, technical debt reduction, B2B engineering',
            ],
            [
                'title' => '7 Signs Your Software Has Become Technical Debt',
                'excerpt' => 'Identify the critical indicators that your custom business systems have outgrown their original architecture and require engineering modernization.',
                'content' => '<h4>When Software Becomes a Business Liability</h4><p>Technical debt isn\'t just an engineering problem; it directly impacts your bottom line. If your business is growing but your software is slowing down, you are likely suffering from deep architectural decay.</p><h4>Key Indicators:</h4><ul><li><strong>Fear of Deployment:</strong> Releases are stressful and frequently cause system outages.</li><li><strong>Rising Maintenance Costs:</strong> You spend more time fixing bugs than building new features.</li><li><strong>Team Dependency:</strong> Only one developer understands how a critical legacy system works.</li><li><strong>Security & Compliance Risks:</strong> You are running unsupported software and library versions.</li></ul>',
                'meta_title' => '7 Signs Your Software is Technical Debt | Sigmatic Soft',
                'meta_description' => 'Learn how to diagnose software technical debt before it halts your business operations or slows product development.',
                'meta_keywords' => 'Modernization, technical debt signs, legacy software modernization, codebase health, software audit',
            ],
            [
                'title' => 'Why Business Systems Fail to Integrate',
                'excerpt' => 'Explore the common architectural mistakes that lead to synchronization errors, data silos, and failed business system integrations.',
                'content' => '<h4>The Disconnected Enterprise</h4><p>Modern companies use dozens of specialized platforms: Shopify for retail, custom ERPs for warehouse management, Salesforce for CRMs, and QuickBooks for accounting. But when these systems don\'t talk to each other, employees waste hours manually copying data.</p><h4>1. Point-to-Point Spaghetti Architecture</h4><p>Connecting every system directly to every other system creates an unmaintainable mess. A change in one API breaks three other integrations.</p><h4>2. The Middleware Solution</h4><p>Implementing a centralized integration layer or event-driven broker handles retry mechanisms, error logging, and data transformations reliably.</p>',
                'meta_title' => 'Why System Integrations Fail & How to Fix Them | Sigmatic Soft',
                'meta_description' => 'Common causes of API synchronization errors and integration bottlenecks in B2B systems architecture.',
                'meta_keywords' => 'Integration, business system integration, API synchronization, event-driven architecture, middleware',
            ],
            [
                'title' => 'Shopify + ERP Integration Architecture',
                'excerpt' => 'A technical blueprint for connecting Shopify to centralized ERP systems to automate inventory, orders, and logistics sync.',
                'content' => '<h4>Automating the Retail Value Chain</h4><p>For growing e-commerce businesses, inventory discrepancies are a major pain point. Overselling, late shipping, and manual stock updates ruin customer trust. A reliable integration between Shopify and your ERP (like SAP, NetSuite, or a custom build) solves this.</p><h4>1. Bidirectional Data Flows</h4><p>Inventory counts must flow from the ERP to Shopify in real-time. Orders and customer records must flow from Shopify to the ERP instantly upon checkout.</p><h4>2. Resiliency & Webhook Handling</h4><p>APIs fail and rate limits are reached. A robust integration architecture uses message queues (like RabbitMQ or Laravel Queue) to guarantee delivery.</p>',
                'meta_title' => 'Shopify to ERP Integration Architecture | Sigmatic Soft',
                'meta_description' => 'Technical blueprint for Shopify and ERP synchronization to automate retail inventory, logistics, and billing workflows.',
                'meta_keywords' => 'Integration, Shopify ERP integration, inventory sync, e-commerce automation, queue system integration',
            ],
            [
                'title' => 'Building Reliable Webhook-Based Integrations',
                'excerpt' => 'Best practices for designing, securing, and operating webhook integrations with robust retry queues and event validation.',
                'content' => '<h4>The Challenge of Real-Time Events</h4><p>Webhooks are the backbone of real-time web communication. However, relying on webhooks without a solid engineering strategy is dangerous. If your server is down for five minutes, you lose valuable transactions and web hooks forever.</p><h4>1. Idempotency is Mandatory</h4><p>Due to retries, your webhook receiver might process the same payload twice. Implement unique event ID checks to prevent duplicate charges or double shipping.</p><h4>2. Secure Signature Verification</h4><p>Always verify the cryptographic signature of incoming webhooks to ensure they originate from the trusted source (e.g., Stripe, Shopify) and not a malicious attacker.</p>',
                'meta_title' => 'Reliable Webhook Integrations Best Practices | Sigmatic Soft',
                'meta_description' => 'How to build resilient webhook receivers with signature verification, idempotency, and background queues.',
                'meta_keywords' => 'Integration, webhook integration, API reliability, idempotency webhooks, Laravel queues',
            ],
            [
                'title' => 'Where AI Actually Saves Businesses Time',
                'excerpt' => 'Cut through the AI hype. Discover practical use cases where LLMs and automation tools drive real operational savings and efficiency.',
                'content' => '<h4>Moving Beyond the Hype</h4><p>Artificial Intelligence is currently surrounded by extreme hype. Many businesses rush to add AI chatbots to their sites without a clear operational goal. The real value of AI lies in automating backend workflows, not generating generic text.</p><h4>1. Document & Invoice Processing</h4><p>AI models can parse PDFs, extract structured invoice metadata (vendor, totals, line items), and insert them directly into accounting systems in seconds.</p><h4>2. Customer Inquiry Routing</h4><p>Analyzing incoming customer support emails to classify intent, extract order IDs, and auto-route them to the correct department saves hours of triage daily.</p>',
                'meta_title' => 'Where AI Drives Real Business Value | Sigmatic Soft',
                'meta_description' => 'Cut through the AI hype with concrete operational use cases for document parsing, support triage, and invoice extraction.',
                'meta_keywords' => 'AI Automation, AI business automation, practical AI, document extraction, workflow automation',
            ],
            [
                'title' => 'AI Agents vs Traditional Automation',
                'excerpt' => 'Understand the difference between rigid rule-based workflows and flexible AI agents capable of reasoning and decision-making.',
                'content' => '<h4>From Rules to Reasoning</h4><p>Traditional business automation relies on fixed, deterministic rules (e.g., \'If field X is empty, send email Y\'). These systems break whenever data formats change. AI Agents introduce reasoning and flexibility to automation.</p><h4>1. Traditional Automation</h4><p>Rigid, code-bound pipelines. Fast and reliable for structured tasks (like database inserts) but completely unable to handle unstructured text or unexpected exceptions.</p><h4>2. AI Agents</h4><p>Autonomous systems that use Large Language Models (LLMs) to choose their own actions, call APIs, search databases, and solve open-ended operational tasks dynamically.</p>',
                'meta_title' => 'AI Agents vs Traditional Automation | Sigmatic Soft',
                'meta_description' => 'Compare rigid rule-based software automation with flexible, LLM-powered AI agent systems for business workflows.',
                'meta_keywords' => 'AI Automation, AI agents, robotic process automation, traditional workflow automation, LLM business application',
            ],
            [
                'title' => 'How to Find AI Automation Opportunities',
                'excerpt' => 'A strategic framework for auditing your company\'s processes and mapping high-value workflows suitable for AI automation.',
                'content' => '<h4>Auditing for Automation</h4><p>To implement AI successfully, you must first identify the correct bottlenecks. Asking \'Where can we add AI?\' is the wrong starting point. Instead, ask \'Which operational workflows require manual human reading, decision-making, and typing?\'</p><h4>1. High-Volume, Semi-Structured Workflows</h4><p>Look for workflows where employees receive documents or emails, extract specific parameters, and input them into another system. These are prime candidates for AI.</p><h4>2. The Audit Strategy</h4><p>Map the time spent, error rate, and complexity of each manual workflow. Prioritize automations that yield direct time-savings for core employees.</p>',
                'meta_title' => 'Identify AI Automation Opportunities in Business | Sigmatic Soft',
                'meta_description' => 'A step-by-step process audit guide to find high-impact, high-ROI AI automation opportunities in your workflows.',
                'meta_keywords' => 'AI Automation, business automation audit, AI implementation framework, process modernization, workflow ROI',
            ],
            [
                'title' => 'Why AI Projects Fail Without Good Data',
                'excerpt' => 'The critical role of structured, clean databases and centralized APIs in ensuring AI agent accuracy and preventing hallucinations.',
                'content' => '<h4>Garbage In, Garbage Out</h4><p>AI models are only as smart as the data they can access. Building a sophisticated AI search tool or customer support agent on top of messy, disconnected spreadsheets and outdated database systems is a recipe for failure.</p><h4>1. The Need for Retrieval-Augmented Generation (RAG)</h4><p>AI needs access to your internal documentation, order history, and logistics data. Without unified APIs and clean databases, the AI will hallucinate and give wrong answers.</p><h4>2. Building the Data Foundation First</h4><p>Before launching an AI pilot, ensure your core business databases are clean, standardized, and accessible via secure API endpoints.</p>',
                'meta_title' => 'Why AI Projects Fail: The Data Problem | Sigmatic Soft',
                'meta_description' => 'How bad database architecture and disconnected systems cause AI hallucinations and lead to failed automation pilots.',
                'meta_keywords' => 'AI Automation, AI data foundation, RAG architecture, database modernization, AI failure reasons',
            ],
            [
                'title' => 'When a Business Outgrows Its POS',
                'excerpt' => 'Signs that your retail business has outgrown its point-of-sale software and needs a unified multi-terminal business system.',
                'content' => '<h4>The Retail Scaling Bottleneck</h4><p>A simple Point-of-Sale (POS) system works fine for a single retail store. But as soon as you expand to multiple locations, launch an online store, or start wholesale distribution, a basic POS becomes an operational bottleneck.</p><h4>Signs of Outgrowing:</h4><ul><li><strong>Inventory Desync:</strong> Stock sold online is still shown as available in the physical store.</li><li><strong>Manual Sales Reports:</strong> Managers spend hours merging Excel sheets from different terminals at the end of the day.</li><li><strong>Slow Checkout:</strong> The system lags under heavy transaction volumes or large customer databases.</li></ul>',
                'meta_title' => 'When to Upgrade Your POS System | Sigmatic Soft',
                'meta_description' => 'Diagnose point-of-sale limitations and understand when your retail business needs a centralized inventory and sales platform.',
                'meta_keywords' => 'Business Systems, POS upgrade, retail software, multi-store inventory, e-commerce POS sync',
            ],
            [
                'title' => 'Centralized Management Systems for Growing Businesses',
                'excerpt' => 'How centralizing inventory, purchasing, sales, and logistics into a single business management system eliminates manual errors.',
                'content' => '<h4>The Single Source of Truth</h4><p>As a business scales, disconnected systems lead to operational chaos. Sales uses one tool, warehouse uses another, and finance uses a third. A Centralized Business Management System consolidates these operations into one platform.</p><h4>1. Real-Time Operations Visibility</h4><p>Decision-makers can view inventory levels across all warehouses, check pending sales orders, and analyze profit margins from a single dashboard instantly.</p><h4>2. Reducing Manual Information Hand-offs</h4><p>Automating order transitions from sales to warehousing and shipping eliminates communication errors and accelerates fulfillment cycles.</p>',
                'meta_title' => 'Centralized Business Management Systems | Sigmatic Soft',
                'meta_description' => 'Learn how centralized custom management software replaces manual spreadsheets and unifies retail, warehouse, and finance ops.',
                'meta_keywords' => 'Business Systems, centralized business management system, custom ERP, warehouse software, operations automation',
            ],
            [
                'title' => 'Why Spreadsheets Become Operational Debt',
                'excerpt' => 'Why relying on Microsoft Excel or Google Sheets for critical business operations slows scaling and introduces security risks.',
                'content' => '<h4>The Spreadsheet Trap</h4><p>Spreadsheets are the ultimate Swiss Army knife of business. They are easy to set up and modify. However, when spreadsheets are used to manage inventory, track logistics, or record financial ledgers for a growing company, they become serious operational debt.</p><h4>1. Lack of Data Validation</h4><p>A single typo or copy-paste error in a cell can break complex formulas, leading to incorrect purchasing decisions or financial reporting errors.</p><h4>2. Zero Audit Trail & Security Risks</h4><p>Excel sheets can be easily duplicated, shared, or accidentally deleted. There is no historical log of who changed what data, leading to operational opacity.</p>',
                'meta_title' => 'Why Spreadsheets are Operational Debt | Sigmatic Soft',
                'meta_description' => 'Discover how relying on Excel and Google Sheets for core business workflows introduces security flaws and limits growth.',
                'meta_keywords' => 'Business Systems, spreadsheet debt, Excel risk, custom software development, business system modernization',
            ],
        ];

        foreach ($insights as $ins) {
            $ins['slug'] = \Illuminate\Support\Str::slug($ins['title']);
            \App\Models\Insight::updateOrCreate(['slug' => $ins['slug']], $ins);
        }

        // 6. Seed Product/Blog Categories
        $blogCategories = [
            ['name' => 'Software Development', 'slug' => 'software-development', 'is_active' => 1],
            ['name' => 'MVP & Startups', 'slug' => 'mvp-startups', 'is_active' => 1],
            ['name' => 'Business Digitization', 'slug' => 'business-digitization', 'is_active' => 1],
            ['name' => 'Modernization', 'slug' => 'modernization', 'is_active' => 1],
            ['name' => 'Integration', 'slug' => 'integration', 'is_active' => 1],
            ['name' => 'AI Automation', 'slug' => 'ai-automation', 'is_active' => 1],
            ['name' => 'Business Systems', 'slug' => 'business-systems', 'is_active' => 1],
        ];

        foreach ($blogCategories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 7. Seed Case Studies
        $this->call(CaseStudySeeder::class);
    }
}
