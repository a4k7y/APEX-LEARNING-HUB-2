
document.addEventListener('DOMContentLoaded', () => {
    const profileMenu = document.querySelector('[data-profile-menu]');
    const profileMenuTrigger = document.querySelector('[data-profile-menu-trigger]');
    const profileMenuContent = document.querySelector('[data-profile-menu-content]');
    if (document.documentElement.dataset.portalProfileBound) {
        // The shared student script already owns profile interactions.
    } else {
    const setProfileMenuOpen = (open) => {
        profileMenuTrigger?.setAttribute('aria-expanded', String(open));
        if (profileMenuContent) profileMenuContent.hidden = !open;
    };

    profileMenuTrigger?.addEventListener('click', () => {
        setProfileMenuOpen(profileMenuTrigger.getAttribute('aria-expanded') !== 'true');
    });
    document.addEventListener('click', event => {
        if (profileMenu && !profileMenu.contains(event.target)) setProfileMenuOpen(false);
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') setProfileMenuOpen(false);
    });
    document.documentElement.dataset.portalProfileBound = 'true';
    }

    const dashboardShell = document.getElementById('studentDashboardShell');
    const sidebarToggle = document.querySelector('.student-sidebar-toggle');
    const mobileToggle = document.querySelector('.student-mobile-toggle');
    const sidebarBackdrop = document.querySelector('.student-sidebar-backdrop');

    if (document.documentElement.dataset.portalSidebarBound) {
        return;
    }
    document.documentElement.dataset.portalSidebarBound = 'true';

    const setSidebarState = (open) => {
        if (!dashboardShell) return;
        dashboardShell.classList.toggle('sidebar-open', open);
        mobileToggle?.setAttribute('aria-expanded', String(open));
        sidebarToggle?.setAttribute('aria-expanded', String(open));
        sidebarToggle?.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
        mobileToggle?.setAttribute('aria-label', open ? 'Close admin navigation' : 'Open admin navigation');
    };

    sidebarToggle?.addEventListener('click', () => {
        if (window.matchMedia('(max-width: 900px)').matches) {
            setSidebarState(!dashboardShell?.classList.contains('sidebar-open'));
            return;
        }

        const collapsed = dashboardShell?.classList.toggle('sidebar-collapsed') ?? false;
        sidebarToggle.setAttribute('aria-expanded', String(!collapsed));
        sidebarToggle.setAttribute('aria-label', collapsed ? 'Expand navigation' : 'Collapse navigation');
    });

    mobileToggle?.addEventListener('click', () => {
        setSidebarState(!dashboardShell?.classList.contains('sidebar-open'));
    });
    sidebarBackdrop?.addEventListener('click', () => setSidebarState(false));

    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');

            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            const targetPanel = document.getElementById(targetId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });

    const hashTarget = window.location.hash.slice(1);
    if (hashTarget) {
        const hashButton = document.querySelector(`.tab-btn[data-target="${hashTarget}"]`);
        hashButton?.click();
    }

    const openModalBtns = document.querySelectorAll('[data-open-modal]');
    const closeModalBtns = document.querySelectorAll('[data-close-modal]');
    const modalBackdrops = document.querySelectorAll('.modal-backdrop');

    openModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const modalId = btn.getAttribute('data-open-modal');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
            }
        });
    });

    const lessonFileInput = document.getElementById('lesson_file');
    const lessonFileName = document.getElementById('lessonFileName');
    lessonFileInput?.addEventListener('change', () => {
        const file = lessonFileInput.files?.[0];
        if (file && lessonFileName) {
            lessonFileName.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        }
    });

    const userRoleSelect = document.querySelector('[data-student-course-toggle]');
    const studentCourseGroup = document.getElementById('studentCourseGroup');
    const studentCourseSelect = document.getElementById('user_course_id');
    const updateStudentCourseVisibility = () => {
        const isStudent = userRoleSelect?.value === 'student';
        if (studentCourseGroup) studentCourseGroup.hidden = !isStudent;
        if (studentCourseSelect) studentCourseSelect.required = isStudent;
    };
    userRoleSelect?.addEventListener('change', updateStudentCourseVisibility);
    updateStudentCourseVisibility();

    const assessmentQuestions = document.getElementById('assessmentQuestions');
    const addQuestionButton = document.querySelector('[data-add-question]');
    const updateQuestionType = (editor) => {
        const type = editor.querySelector('.assessment-question-type')?.value;
        const choicesGroup = editor.querySelector('.assessment-choices-group');
        const choices = editor.querySelector('[name$="[choices]"]');
        const answer = editor.querySelector('.assessment-answer');
        if (choicesGroup) choicesGroup.hidden = type !== 'multiple_choice';
        if (choices) choices.required = false;
        if (answer) answer.placeholder = type === 'multiple_choice' ? 'Enter the exact correct choice' : 'Enter the expected answer';
    };
    assessmentQuestions?.querySelectorAll('.assessment-question-editor').forEach(editor => {
        editor.querySelector('.assessment-question-type')?.addEventListener('change', () => updateQuestionType(editor));
        updateQuestionType(editor);
    });
    addQuestionButton?.addEventListener('click', () => {
        if (!assessmentQuestions) return;
        const index = assessmentQuestions.querySelectorAll('.assessment-question-editor').length;
        const editor = document.createElement('div');
        editor.className = 'assessment-question-editor';
        editor.innerHTML = `
            <div class="assessment-question-editor-heading"><strong>Question ${index + 1}</strong><button type="button" class="assessment-remove-question">Remove</button></div>
            <div class="form-group"><label>Question *</label><textarea name="questions[${index}][text]" class="form-control" rows="2" required></textarea></div>
            <div class="form-group"><label>Question type *</label><select name="questions[${index}][type]" class="form-control assessment-question-type"><option value="multiple_choice">Multiple choice</option><option value="identification">Identification</option></select></div>
            <div class="form-group assessment-choices-group"><label>Choices (one per line, optional)</label><textarea name="questions[${index}][choices]" class="form-control" rows="3" placeholder="Choice A&#10;Choice B&#10;Choice C"></textarea></div>
            <div class="form-group"><label>Correct answer *</label><input name="questions[${index}][answer]" class="form-control assessment-answer" required></div>`;
        assessmentQuestions.appendChild(editor);
        editor.querySelector('.assessment-question-type')?.addEventListener('change', () => updateQuestionType(editor));
        editor.querySelector('.assessment-remove-question')?.addEventListener('click', () => editor.remove());
        updateQuestionType(editor);
    });

    document.querySelectorAll('.course-schedule-edit').forEach(button => {
        button.addEventListener('click', () => {
            const modal = document.getElementById('courseScheduleModal');
            if (!modal) return;

            modal.querySelector('#schedule_course_id').value = button.dataset.courseId || '';
            modal.querySelector('#schedule_course_name').textContent = button.dataset.courseName || '';
            modal.querySelector('#schedule_start_time').value = button.dataset.start || '';
            modal.querySelector('#schedule_end_time').value = button.dataset.end || '';
            modal.querySelector('#schedule_room').value = button.dataset.room || '';

            const days = (button.dataset.days || '').split(',').filter(Boolean);
            modal.querySelectorAll('input[name="meeting_days[]"]').forEach(input => {
                input.checked = days.includes(input.value);
            });
        });
    });

    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.modal-backdrop');
            if (modal) {
                modal.classList.remove('active');
            }
        });
    });

    modalBackdrops.forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });

    const searchInputs = document.querySelectorAll('[data-table-search]');
    searchInputs.forEach(input => {
        const tableId = input.getAttribute('data-table-search');
        const table = document.getElementById(tableId);
        if (!table) return;

        input.addEventListener('input', () => {
            const query = input.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    const autoAlerts = document.querySelectorAll('.alert');
    autoAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 400);
        }, 4500);
    });
});
