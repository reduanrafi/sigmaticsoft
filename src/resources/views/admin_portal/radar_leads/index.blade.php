@extends('layouts.portal_admin')

@section('extra-style')
<style>
/* Problem Radar Container & Scoped Styles */
.radar-manager {
  max-width: 1200px;
  margin: 0 auto;
  font-family: inherit;
  color: #1e293b;
}

.radar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.main-title {
  font-size: 24px;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 6px 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.subtitle {
  font-size: 14px;
  color: #64748b;
  margin: 0;
}

.refresh-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
}

.refresh-btn:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
}

.refresh-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.icon {
  width: 18px;
  height: 18px;
}

.spin {
  animation: radar-spin 1s linear infinite;
}

@keyframes radar-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  background: #ffffff;
  padding: 18px;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
}

.stat-card.active {
  border-color: #4F46E5;
  background: #f5f3ff;
  box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
}

.stat-num {
  font-size: 28px;
  font-weight: 800;
  color: #0f172a;
}

.stat-label {
  font-size: 13px;
  font-weight: 600;
  color: #64748b;
  margin-top: 4px;
}

.stat-card.new .stat-num { color: #d97706; }
.stat-card.initiated .stat-num { color: #0284c7; }
.stat-card.contacted .stat-num { color: #7c3aed; }
.stat-card.high-priority .stat-num { color: #10b981; }

/* Filter & Search Bar */
.controls-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  background: #ffffff;
  padding: 16px;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  margin-bottom: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.search-box {
  flex: 1;
  min-width: 280px;
  position: relative;
}

.search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  color: #94a3b8;
}

.search-box input {
  width: 100%;
  padding: 10px 12px 10px 40px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 14px;
  outline: none;
  box-sizing: border-box;
}

.search-box input:focus {
  border-color: #4F46E5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.filters-row {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.select-control {
  padding: 10px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 14px;
  background: #fff;
  color: #334155;
  cursor: pointer;
  outline: none;
}

.select-control:focus {
  border-color: #4F46E5;
}

/* Leads List */
.leads-list {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.lead-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-left-width: 5px;
  border-radius: 12px;
  padding: 22px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
  transition: all 0.2s ease;
}

.lead-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
}

.border-new { border-left-color: #f59e0b; }
.border-initiated { border-left-color: #0284c7; }
.border-contacted { border-left-color: #7c3aed; }
.border-won { border-left-color: #10b981; }
.border-ignored { border-left-color: #94a3b8; }

.lead-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.tags-group {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
}

.source-tag {
  background: #f1f5f9;
  color: #475569;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: 6px;
  letter-spacing: 0.5px;
}

.service-tag {
  background: #e0f2fe;
  color: #0369a1;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 6px;
}

.budget-tag {
  background: #fef3c7;
  color: #b45309;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 6px;
}

.status-badge {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 4px 8px;
  border-radius: 6px;
}

.status-new { background: #fef3c7; color: #b45309; }
.status-initiated { background: #e0f2fe; color: #0369a1; }
.status-contacted { background: #ede9fe; color: #6d28d9; }
.status-won { background: #dcfce7; color: #15803d; }
.status-ignored { background: #f1f5f9; color: #64748b; }

.score-badge {
  font-size: 14px;
  font-weight: 700;
  padding: 5px 12px;
  border-radius: 8px;
}

.score-high { background: #dcfce7; color: #166534; }
.score-medium { background: #e0f2fe; color: #075985; }
.score-low { background: #f1f5f9; color: #64748b; }

.lead-title {
  margin: 0 0 8px 0;
  font-size: 18px;
  font-weight: 600;
}

.lead-title a {
  color: #0f172a;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.lead-title a:hover {
  color: #4F46E5;
}

.external-icon {
  width: 16px;
  height: 16px;
  color: #94a3b8;
}

.author-meta {
  display: flex;
  gap: 8px;
  font-size: 13px;
  color: #64748b;
  margin-bottom: 14px;
}

.summary-box {
  background: #f8fafc;
  border-left: 3px solid #cbd5e1;
  padding: 10px 14px;
  font-size: 14px;
  color: #334155;
  margin-bottom: 14px;
  border-radius: 0 6px 6px 0;
}

.reply-box {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  padding: 14px;
  border-radius: 8px;
  margin-bottom: 14px;
}

.reply-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
  font-weight: 600;
  color: #166534;
  margin-bottom: 8px;
}

.copy-btn {
  background: #ffffff;
  border: 1px solid #86efac;
  color: #15803d;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
}

.copy-btn:hover {
  background: #dcfce7;
}

.reply-text {
  margin: 0;
  font-size: 14px;
  line-height: 1.5;
  color: #1e293b;
}

.notes-preview {
  background: #fffbeb;
  border: 1px solid #fde68a;
  padding: 10px 14px;
  border-radius: 6px;
  font-size: 13px;
  color: #92400e;
  margin-bottom: 14px;
}

.notes-text {
  margin: 4px 0 0 0;
  font-family: inherit;
  white-space: pre-wrap;
}

.lead-actions {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  padding-top: 14px;
  border-top: 1px solid #f1f5f9;
}

.status-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
}

.action-label {
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
  margin-right: 4px;
}

.btn-status {
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  border: 1px solid transparent;
  transition: all 0.2s;
}

.btn-status.initiated {
  background: #e0f2fe;
  color: #0369a1;
  border-color: #bae6fd;
}
.btn-status.initiated:hover { background: #bae6fd; }

.btn-status.contacted {
  background: #ede9fe;
  color: #6d28d9;
  border-color: #ddd6fe;
}
.btn-status.contacted:hover { background: #ddd6fe; }

.btn-status.won {
  background: #dcfce7;
  color: #15803d;
  border-color: #bbf7d0;
}
.btn-status.won:hover { background: #bbf7d0; }

.btn-status.ignore {
  background: #f1f5f9;
  color: #64748b;
  border-color: #e2e8f0;
}
.btn-status.ignore:hover { background: #e2e8f0; }

.utility-actions {
  display: flex;
  gap: 8px;
}

.btn-utility {
  padding: 6px 12px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
  text-decoration: none;
}

.btn-utility:hover {
  background: #f8fafc;
}

.btn-utility.primary {
  background: #4F46E5;
  border-color: #4F46E5;
  color: #ffffff;
}

.btn-utility.primary:hover {
  background: #4338ca;
}

.btn-utility.danger {
  color: #ef4444;
  border-color: #fecaca;
}
.btn-utility.danger:hover {
  background: #fee2e2;
}

/* Pagination */
.pagination-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  margin-top: 24px;
}

.page-btn {
  padding: 8px 16px;
  border: 1px solid #cbd5e1;
  background: #fff;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  font-size: 14px;
  color: #64748b;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal-dialog {
  background: #fff;
  border-radius: 12px;
  width: 90%;
  max-width: 520px;
  padding: 24px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.modal-header h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 700;
}

.close-x {
  border: none;
  background: none;
  font-size: 22px;
  cursor: pointer;
}

.notes-textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  box-sizing: border-box;
  font-family: inherit;
  font-size: 14px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 16px;
}

.btn-secondary {
  padding: 8px 16px;
  background: #f1f5f9;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  cursor: pointer;
}

.btn-primary {
  padding: 8px 16px;
  background: #4F46E5;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.state-container {
  text-align: center;
  padding: 48px;
  background: #fff;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  color: #64748b;
}

.empty-icon {
  width: 48px;
  height: 48px;
  margin-bottom: 12px;
  color: #94a3b8;
}

.loading-spinner {
  width: 32px;
  height: 32px;
  border: 3px solid #e2e8f0;
  border-top-color: #4F46E5;
  border-radius: 50%;
  animation: radar-spin 0.8s linear infinite;
  margin: 0 auto 12px auto;
}
</style>
@endsection

@section('content')
<div id="radar-leads-app">
@verbatim
  <div class="radar-manager">
    <!-- Header & Metric Cards -->
    <div class="radar-header">
      <div class="title-section">
        <h1 class="main-title">
          <i class="mdi mdi-radar text-primary"></i>
          Lead Radar & Pain-Point Intelligence
        </h1>
        <p class="subtitle">Scraped high-intent client opportunities, problems, and outreach assistance</p>
      </div>
      <button class="refresh-btn" @click="fetchData" :disabled="loading">
        <svg class="icon" :class="{ 'spin': loading }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Refresh Leads
      </button>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
      <div class="stat-card" :class="{ active: currentFilter.status === 'all' }" @click="setStatusFilter('all')">
        <div class="stat-num">{{ stats.total }}</div>
        <div class="stat-label">Total Leads</div>
      </div>
      <div class="stat-card new" :class="{ active: currentFilter.status === 'new' }" @click="setStatusFilter('new')">
        <div class="stat-num">{{ stats.new }}</div>
        <div class="stat-label">New / Unhandled</div>
      </div>
      <div class="stat-card initiated" :class="{ active: currentFilter.status === 'initiated' }" @click="setStatusFilter('initiated')">
        <div class="stat-num">{{ stats.initiated }}</div>
        <div class="stat-label">Initiated</div>
      </div>
      <div class="stat-card contacted" :class="{ active: currentFilter.status === 'contacted' }" @click="setStatusFilter('contacted')">
        <div class="stat-num">{{ stats.contacted }}</div>
        <div class="stat-label">Contacted</div>
      </div>
      <div class="stat-card high-priority" :class="{ active: currentFilter.min_score === 8 }" @click="toggleHighPriority">
        <div class="stat-num">{{ stats.high_priority }}</div>
        <div class="stat-label">Hot Leads (Score 8+)</div>
      </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="controls-bar">
      <div class="search-box">
        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
          v-model="searchQuery"
          @input="debounceSearch"
          type="text"
          placeholder="Search by keywords, author, company or title..."
        />
      </div>

      <div class="filters-row">
        <!-- Service Fit Filter -->
        <select v-model="currentFilter.service_fit" @change="fetchLeads" class="select-control">
          <option value="all">All Services</option>
          <option value="legacy_modernization">Legacy Modernization (PHP/Laravel)</option>
          <option value="integration">System & POS Integration</option>
          <option value="ai_automation">AI & Workflow Automation</option>
          <option value="managed_engineering">Managed Engineering</option>
          <option value="audit">Code / Architecture Audit</option>
        </select>

        <!-- Minimum Score Filter -->
        <select v-model="currentFilter.min_score" @change="fetchLeads" class="select-control">
          <option :value="0">All Scores</option>
          <option :value="6">Score 6+ (Good)</option>
          <option :value="8">Score 8+ (High Intent)</option>
        </select>
      </div>
    </div>

    <!-- Leads List -->
    <div v-if="loading" class="state-container">
      <div class="loading-spinner"></div>
      <p>Loading radar leads...</p>
    </div>

    <div v-else-if="leads.length === 0" class="state-container empty">
      <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3>No leads matching criteria</h3>
      <p>Try clearing filters or run the scraper to gather fresh opportunities.</p>
    </div>

    <div v-else class="leads-list">
      <div v-for="lead in leads" :key="lead.id" class="lead-card" :class="`border-${lead.status}`">
        <!-- Top Metadata Row -->
        <div class="lead-top">
          <div class="tags-group">
            <span class="source-tag">{{ formatSource(lead.source) }}</span>
            <span v-if="lead.service_fit" class="service-tag">{{ formatFit(lead.service_fit) }}</span>
            <span v-if="lead.budget_signal && lead.budget_signal !== 'none'" class="budget-tag">
              💰 Budget: {{ lead.budget_signal }}
            </span>
            <span :class="['status-badge', `status-${lead.status}`]">
              {{ lead.status.replace('_', ' ') }}
            </span>
          </div>

          <div class="score-badge" :class="scoreClass(lead.ai_score)">
            ★ {{ lead.ai_score }}/10
          </div>
        </div>

        <!-- Post Title & Meta -->
        <h2 class="lead-title">
          <a :href="lead.url" target="_blank" rel="noopener noreferrer">
            {{ lead.title }}
            <svg class="external-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
        </h2>

        <div class="author-meta">
          <span>By <strong>{{ lead.author || 'Anonymous' }}</strong></span>
          <span>•</span>
          <span>Found {{ formatDate(lead.found_at) }}</span>
          <span v-if="lead.last_action_at">• Active {{ formatDate(lead.last_action_at) }}</span>
        </div>

        <!-- Problem Summary -->
        <div v-if="lead.problem_summary" class="summary-box">
          <strong>Identified Problem:</strong> {{ lead.problem_summary }}
        </div>

        <!-- AI Suggested Reply Box -->
        <div v-if="lead.suggested_reply" class="reply-box">
          <div class="reply-header">
            <span>✨ AI Suggested Helpful Reply:</span>
            <button class="copy-btn" @click="copyReply(lead)">
              {{ copiedId === lead.id ? '✓ Copied!' : 'Copy Reply' }}
            </button>
          </div>
          <p class="reply-text">{{ lead.suggested_reply }}</p>
        </div>

        <!-- Notes / Internal Log -->
        <div v-if="lead.notes" class="notes-preview">
          <strong>Notes:</strong>
          <pre class="notes-text">{{ lead.notes }}</pre>
        </div>

        <!-- Actions Footer -->
        <div class="lead-actions">
          <div class="status-actions">
            <span class="action-label">Change Status:</span>
            <button
              v-if="lead.status !== 'initiated'"
              @click="changeStatus(lead, 'initiated')"
              class="btn-status initiated"
            >
              Mark Initiated
            </button>

            <button
              v-if="lead.status !== 'contacted'"
              @click="changeStatus(lead, 'contacted')"
              class="btn-status contacted"
            >
              Mark Contacted
            </button>

            <button
              v-if="lead.status !== 'won'"
              @click="changeStatus(lead, 'won')"
              class="btn-status won"
            >
              Client Won 🎉
            </button>

            <button
              v-if="lead.status !== 'ignored'"
              @click="changeStatus(lead, 'ignored')"
              class="btn-status ignore"
            >
              Ignore
            </button>
          </div>

          <div class="utility-actions">
            <button @click="openNotesModal(lead)" class="btn-utility">
              📝 {{ lead.notes ? 'Edit Notes' : 'Add Note' }}
            </button>
            <a :href="lead.url" target="_blank" class="btn-utility primary">
              Open Post ↗
            </a>
            <button @click="removeLead(lead)" class="btn-utility danger" title="Delete or Dismiss Lead">
              ✕
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div v-if="pagination.last_page > 1" class="pagination-bar">
        <button
          :disabled="pagination.current_page <= 1"
          @click="changePage(pagination.current_page - 1)"
          class="page-btn"
        >
          Previous
        </button>
        <span class="page-info">
          Page {{ pagination.current_page }} of {{ pagination.last_page }}
        </span>
        <button
          :disabled="pagination.current_page >= pagination.last_page"
          @click="changePage(pagination.current_page + 1)"
          class="page-btn"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Notes Modal -->
    <div v-if="activeLeadForNotes" class="modal-overlay" @click.self="closeNotesModal">
      <div class="modal-dialog">
        <div class="modal-header">
          <h3>Lead Outreach Notes: {{ activeLeadForNotes.title.slice(0, 50) }}...</h3>
          <button class="close-x" @click="closeNotesModal">×</button>
        </div>
        <div class="modal-body">
          <textarea
            v-model="tempNotes"
            rows="6"
            placeholder="Add discussion notes, client email, or response status..."
            class="notes-textarea"
          ></textarea>
        </div>
        <div class="modal-footer">
          <button @click="closeNotesModal" class="btn-secondary">Cancel</button>
          <button @click="saveNotes" class="btn-primary" :disabled="savingNotes">
            {{ savingNotes ? 'Saving...' : 'Save Notes' }}
          </button>
        </div>
      </div>
    </div>
  </div>
@endverbatim
</div>
@endsection

@section('script')
<!-- Local Vue 3 Runtime with CDN Fallback -->
<script src="{{ asset('assets/admin/vendors/vue/vue.global.prod.js') }}"></script>
<script>
if (typeof Vue === 'undefined') {
  document.write('<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"><\/script>');
}
</script>

<script>
window.RADAR_API_BASE = "{{ url('api/radar-leads') }}";
window.CSRF_TOKEN = "{{ csrf_token() }}";

(function() {
  const { createApp, ref, onMounted } = Vue;

  const API_BASE = window.RADAR_API_BASE || '/api/radar-leads';

  const app = createApp({
    setup() {
      const leads = ref([]);
      const loading = ref(false);
      const copiedId = ref(null);
      const searchQuery = ref('');
      let searchTimeout = null;

      const stats = ref({
        total: 0,
        new: 0,
        initiated: 0,
        contacted: 0,
        in_discussion: 0,
        won: 0,
        ignored: 0,
        high_priority: 0,
      });

      const currentFilter = ref({
        status: 'all',
        service_fit: 'all',
        min_score: 0,
        page: 1,
      });

      const pagination = ref({
        current_page: 1,
        last_page: 1,
        total: 0,
      });

      const activeLeadForNotes = ref(null);
      const tempNotes = ref('');
      const savingNotes = ref(false);

      // Fetch aggregate statistics
      async function fetchStats() {
        try {
          const res = await fetch(`${API_BASE}/stats`);
          if (res.ok) {
            stats.value = await res.json();
          }
        } catch (err) {
          console.error('Failed to load stats:', err);
        }
      }

      // Fetch leads list with filters
      async function fetchLeads() {
        loading.value = true;
        try {
          const params = new URLSearchParams();
          if (currentFilter.value.status !== 'all') params.append('status', currentFilter.value.status);
          if (currentFilter.value.service_fit !== 'all') params.append('service_fit', currentFilter.value.service_fit);
          if (currentFilter.value.min_score > 0) params.append('min_score', currentFilter.value.min_score);
          if (searchQuery.value) params.append('search', searchQuery.value);
          params.append('page', currentFilter.value.page);

          const res = await fetch(`${API_BASE}?${params.toString()}`);
          if (res.ok) {
            const data = await res.json();
            leads.value = data.data || [];
            pagination.value = {
              current_page: data.current_page || 1,
              last_page: data.last_page || 1,
              total: data.total || 0,
            };
          }
        } catch (err) {
          console.error('Failed to load leads:', err);
        } finally {
          loading.value = false;
        }
      }

      function fetchData() {
        fetchStats();
        fetchLeads();
      }

      function setStatusFilter(status) {
        currentFilter.value.status = status;
        currentFilter.value.page = 1;
        fetchLeads();
      }

      function toggleHighPriority() {
        currentFilter.value.min_score = currentFilter.value.min_score === 8 ? 0 : 8;
        currentFilter.value.page = 1;
        fetchLeads();
      }

      function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          currentFilter.value.page = 1;
          fetchLeads();
        }, 350);
      }

      function changePage(page) {
        currentFilter.value.page = page;
        fetchLeads();
      }

      // Update lead status
      async function changeStatus(lead, newStatus) {
        try {
          const res = await fetch(`${API_BASE}/${lead.id}/status`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': window.CSRF_TOKEN,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: newStatus }),
          });
          if (res.ok) {
            lead.status = newStatus;
            fetchStats();
          }
        } catch (err) {
          console.error('Failed to update status:', err);
        }
      }

      // Remove / dismiss lead
      async function removeLead(lead) {
        if (!confirm('Are you sure you want to dismiss/delete this lead?')) return;
        try {
          const res = await fetch(`${API_BASE}/${lead.id}`, {
            method: 'DELETE',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': window.CSRF_TOKEN,
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
          if (res.ok) {
            leads.value = leads.value.filter(l => l.id !== lead.id);
            fetchStats();
          }
        } catch (err) {
          console.error('Failed to remove lead:', err);
        }
      }

      // Copy AI Suggested Reply
      async function copyReply(lead) {
        if (!lead.suggested_reply) return;
        try {
          await navigator.clipboard.writeText(lead.suggested_reply);
          copiedId.value = lead.id;
          setTimeout(() => {
            if (copiedId.value === lead.id) copiedId.value = null;
          }, 2500);
        } catch (err) {
          console.error('Clipboard copy error:', err);
        }
      }

      // Notes management
      function openNotesModal(lead) {
        activeLeadForNotes.value = lead;
        tempNotes.value = lead.notes || '';
      }

      function closeNotesModal() {
        activeLeadForNotes.value = null;
        tempNotes.value = '';
      }

      async function saveNotes() {
        if (!activeLeadForNotes.value) return;
        savingNotes.value = true;
        try {
          const res = await fetch(`${API_BASE}/${activeLeadForNotes.value.id}/notes`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': window.CSRF_TOKEN,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ notes: tempNotes.value }),
          });
          if (res.ok) {
            activeLeadForNotes.value.notes = tempNotes.value;
            closeNotesModal();
          }
        } catch (err) {
          console.error('Failed to save notes:', err);
        } finally {
          savingNotes.value = false;
        }
      }

      // Formatters
      function formatSource(source) {
        return (source || '').replace('/', ' • ').toUpperCase();
      }

      function formatFit(fit) {
        const map = {
          legacy_modernization: 'Legacy Modernization',
          integration: 'System Integration',
          ai_automation: 'AI Automation',
          managed_engineering: 'Managed Dev',
          audit: 'Architecture Audit',
        };
        return map[fit] || fit;
      }

      function formatDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return isNaN(d) ? dateStr : d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
      }

      function scoreClass(score) {
        if (score >= 8) return 'score-high';
        if (score >= 6) return 'score-medium';
        return 'score-low';
      }

      onMounted(() => {
        fetchData();
      });

      return {
        leads,
        loading,
        copiedId,
        searchQuery,
        stats,
        currentFilter,
        pagination,
        activeLeadForNotes,
        tempNotes,
        savingNotes,
        fetchData,
        fetchLeads,
        setStatusFilter,
        toggleHighPriority,
        debounceSearch,
        changePage,
        changeStatus,
        removeLead,
        copyReply,
        openNotesModal,
        closeNotesModal,
        saveNotes,
        formatSource,
        formatFit,
        formatDate,
        scoreClass,
      };
    }
  });

  app.mount('#radar-leads-app');
})();
</script>
@endsection
