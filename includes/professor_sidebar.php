<aside class="student-sidebar" id="studentSidebar" aria-label="Professor dashboard navigation">
    <div class="student-sidebar-heading">
        <span class="student-sidebar-title">Professor Portal</span>
        <button type="button" class="student-sidebar-toggle" aria-label="Collapse navigation"
            aria-controls="studentSidebar" aria-expanded="true">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
    <nav class="student-sidebar-nav" aria-label="Professor sections">
        <a class="student-sidebar-link<?= $professorView === 'dashboard' ? ' active' : '' ?>" href="professor_dashboard.php">
            <span class="student-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7M5 9v11h14V9M9 20v-7h6v7"/></svg></span>
            <span class="student-nav-label">Dashboard</span>
        </a>
        <a class="student-sidebar-link<?= $professorView === 'classes' ? ' active' : '' ?>" href="professor_classes.php">
            <span class="student-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg></span>
            <span class="student-nav-label">Assigned Classes</span>
        </a>
        <a class="student-sidebar-link<?= $professorView === 'schedule' ? ' active' : '' ?>" href="professor_class_schedule.php">
            <span class="student-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg></span>
            <span class="student-nav-label">Teaching Schedule</span>
        </a>
        <button type="button" class="student-sidebar-link student-fiscal-year-trigger" data-fiscal-year-open
            aria-haspopup="dialog" aria-controls="studentFiscalYearDialog">
            <span class="student-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18M8 13h3M13 13h3M8 17h3"/></svg></span>
            <span class="student-nav-label student-fiscal-year-copy">
                <span>Fiscal Year</span>
                <small class="student-fiscal-year-summary" data-fiscal-year-summary>Not set</small>
            </span>
        </button>
        <a class="student-sidebar-link<?= $professorView === 'privacy' ? ' active' : '' ?>" href="professor_privacy.php">
            <span class="student-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 3 19 6v5c0 4.5-2.8 7.8-7 10-4.2-2.2-7-5.5-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/></svg></span>
            <span class="student-nav-label">Privacy Policy</span>
        </a>
    </nav>
</aside>
<?php $fiscalYearStart = (int) date('Y') - 1; ?>
<dialog class="student-fiscal-year-dialog" id="studentFiscalYearDialog" aria-labelledby="studentFiscalYearTitle">
    <form id="studentFiscalYearForm">
        <div class="student-fiscal-year-heading">
            <span class="student-eyebrow">Professor portal</span>
            <button type="button" class="student-fiscal-year-close" data-fiscal-year-close aria-label="Close dialog">&times;</button>
        </div>
        <h2 id="studentFiscalYearTitle">Set a fiscal year</h2>
        <p>Choose the academic year and semester you want to view.</p>
        <label for="studentAcademicYear">Academic year</label>
        <select id="studentAcademicYear" name="academicYear" required>
            <option value="">Select an academic year</option>
            <?php for ($year = $fiscalYearStart; $year <= $fiscalYearStart + 5; $year++): ?>
                <option value="<?= $year ?>-<?= $year + 1 ?>">AY <?= $year ?>–<?= $year + 1 ?></option>
            <?php endfor; ?>
        </select>
        <label for="studentSemester">Semester</label>
        <select id="studentSemester" name="semester" required>
            <option value="">Select a semester</option>
            <option value="first">First Semester</option>
            <option value="second">Second Semester</option>
            <option value="summer">Summer</option>
        </select>
        <p class="student-fiscal-year-status" id="studentFiscalYearStatus" aria-live="polite"></p>
        <div class="student-fiscal-year-actions">
            <button type="button" class="btn btn-outline" data-fiscal-year-close>Cancel</button>
            <button type="submit" class="btn btn-primary">Save selection</button>
        </div>
    </form>
</dialog>
