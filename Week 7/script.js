document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const contactForm = document.getElementById('contactForm');
    const subscriptionForm = document.getElementById('subscriptionForm');
    const feedbackForm = document.getElementById('feedbackForm');
    const responseDiv = document.getElementById('response');
    const loadingAnimation = document.getElementById('loading');
    const successAnimation = document.getElementById('successAnimation');
    const formProgress = document.getElementById('formProgress');
    const submissionsList = document.getElementById('submissionsList');
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    const darkModeToggle = document.getElementById('darkMode');
    const messageTextarea = document.getElementById('message');
    const currentCount = document.getElementById('currentCount');
    const maxCount = document.getElementById('maxCount');
    const resetBtn = document.getElementById('resetBtn');
    const newFormBtn = document.getElementById('newFormBtn');
    
    // Initialize
    setupDarkMode();
    setupTabNavigation();
    setupCharacterCounter();
    setupFormValidation();
    initializeFormProgress();
    
    // Setup event listeners for all forms
    contactForm.addEventListener('submit', handleSubmit);
    subscriptionForm.addEventListener('submit', handleSubmit);
    feedbackForm.addEventListener('submit', handleSubmit);
    resetBtn.addEventListener('click', resetForm);
    newFormBtn.addEventListener('click', newFormRequest);
    
    // Dark Mode Toggle
    function setupDarkMode() {
        // Check for saved theme preference or prefer-color-scheme
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        const savedTheme = localStorage.getItem('theme');
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }
        
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode-transition', 'dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.add('dark-mode-transition');
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
            
            setTimeout(() => {
                document.body.classList.remove('dark-mode-transition');
            }, 300);
        });
    }
    
    // Tab Navigation
    function setupTabNavigation() {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Update active tab button
                tabBtns.forEach(tb => tb.classList.remove('active'));
                this.classList.add('active');
                
                // Update tab content visibility
                tabContents.forEach(content => {
                    if (content.getAttribute('data-tab') === tabId) {
                        content.classList.add('active');
                        
                        // Update heading based on tab
                        const formContainer = document.getElementById('contactFormContainer');
                        const heading = formContainer.querySelector('h1');
                        
                        if (tabId === 'contact') {
                            heading.innerHTML = '<i class="fas fa-paper-plane"></i> Get in Touch';
                        } else if (tabId === 'subscription') {
                            heading.innerHTML = '<i class="fas fa-bell"></i> Stay Updated';
                        } else if (tabId === 'feedback') {
                            heading.innerHTML = '<i class="fas fa-star"></i> Share Your Feedback';
                        }
                        
                        // Reset progress bar when switching tabs
                        updateFormProgress(0);
                        
                        // Reset any response messages
                        responseDiv.className = 'response-message';
                        responseDiv.textContent = '';
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
    }
    
    // Character counter for message textarea
    function setupCharacterCounter() {
        const maxChars = 500;
        maxCount.textContent = maxChars;
        
        messageTextarea.addEventListener('input', function() {
            const remaining = this.value.length;
            currentCount.textContent = remaining;
            
            if (remaining > maxChars) {
                currentCount.style.color = '#e74c3c';
            } else if (remaining > maxChars * 0.8) {
                currentCount.style.color = '#f39c12';
            } else {
                currentCount.style.color = '';
            }
        });
    }
    
    // Form validation setup
    function setupFormValidation() {
        const inputs = document.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Input validation events
            input.addEventListener('blur', function() {
                validateInput(this);
            });
            
            input.addEventListener('input', function() {
                // Clear validation styles while typing
                this.classList.remove('valid', 'invalid');
                
                // Update form progress when any field changes
                updateFormProgressBasedOnCompletion();
            });
            
            // Focus effect
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    }
    
    // Initialize form progress
    function initializeFormProgress() {
        updateFormProgress(0);
    }
    
    // Update form progress based on completion
    function updateFormProgressBasedOnCompletion() {
        const activeForm = document.querySelector('.tab-content.active form');
        if (!activeForm) return;
        
        const requiredFields = activeForm.querySelectorAll('[required]');
        const totalFields = requiredFields.length;
        if (totalFields === 0) return;
        
        let filledFields = 0;
        
        requiredFields.forEach(field => {
            if (field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progressPercentage = (filledFields / totalFields) * 100;
        updateFormProgress(progressPercentage);
    }
    
    // Update the progress bar
    function updateFormProgress(percentage) {
        formProgress.style.width = `${percentage}%`;
        
        if (percentage < 30) {
            formProgress.style.background = 'linear-gradient(to right, #e74c3c, #f39c12)';
        } else if (percentage < 70) {
            formProgress.style.background = 'linear-gradient(to right, #f39c12, #3498db)';
        } else {
            formProgress.style.background = 'linear-gradient(to right, #3498db, #2ecc71)';
        }
    }
    
    // Handle form submission - DIUBAH UNTUK BEKERJA TANPA SERVER PHP
    function handleSubmit(event) {
        event.preventDefault();
        
        // Get the active form
        const activeForm = document.querySelector('.tab-content.active form');
        const formId = activeForm.id;
        const formData = new FormData(activeForm);
        const jsonData = {};
        
        // Convert FormData to JSON
        formData.forEach((value, key) => {
            // Handle checkbox arrays (interests[])
            if (key.endsWith('[]')) {
                const cleanKey = key.slice(0, -2);
                if (!jsonData[cleanKey]) {
                    jsonData[cleanKey] = [];
                }
                jsonData[cleanKey].push(value);
            } else {
                jsonData[key] = value;
            }
        });
        
        // Add form type information
        jsonData.formType = formId;
        
        // Validate form data client-side
        if (!validateForm(activeForm)) {
            return;
        }
        
        // Show loading animation
        loadingAnimation.style.display = 'flex';
        
        // Clear previous response
        responseDiv.className = 'response-message';
        responseDiv.textContent = '';
        
        // SIMULASI AJAX REQUEST - tidak perlu server PHP
        setTimeout(() => {
            // Hide loading spinner
            loadingAnimation.style.display = 'none';
            
            // Simulasi sukses
            // Show success animation
            showSuccessAnimation();
            
            // Save submission to local storage for recent submissions panel
            saveSubmission(jsonData);
            
            // Display recent submissions
            displayRecentSubmissions();
            
        }, 1500); // Delay 1.5 detik untuk mensimulasikan server request
    }
    
    // Validate the entire form
    function validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !validateInput(input)) {
                isValid = false;
            }
        });
        
        // Display form-level error if validation fails
        if (!isValid) {
            showResponse('Please correct the errors in the form before submitting.', 'error');
        }
        
        return isValid;
    }
    
    // Validate individual input fields
    function validateInput(input) {
        const value = input.value.trim();
        const inputType = input.getAttribute('type');
        
        // Skip validation for non-required fields that are empty
        if (!input.hasAttribute('required') && value === '') {
            input.classList.remove('valid', 'invalid');
            return true;
        }
        
        // Required field validation
        if (input.hasAttribute('required') && value === '') {
            input.classList.add('invalid');
            input.classList.remove('valid');
            return false;
        }
        
        // Email validation
        if (inputType === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                input.classList.add('invalid');
                input.classList.remove('valid');
                return false;
            }
        } 
        
        // Phone validation (if present)
        if (inputType === 'tel' && value !== '') {
            const phoneRegex = /^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/;
            if (!phoneRegex.test(value)) {
                input.classList.add('invalid');
                input.classList.remove('valid');
                return false;
            }
        }
        
        // Select validation
        if (input.tagName.toLowerCase() === 'select' && value === '') {
            input.classList.add('invalid');
            input.classList.remove('valid');
            return false;
        }
        
        // If we reached here, input is valid
        input.classList.add('valid');
        input.classList.remove('invalid');
        return true;
    }
    
    // Show response message
    function showResponse(message, type) {
        responseDiv.innerHTML = message;
        responseDiv.className = 'response-message ' + type;
        
        // Scroll to response message
        responseDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    // Show success animation
    function showSuccessAnimation() {
        successAnimation.style.display = 'flex';
        
        // Add animation to checkmark
        const checkmark = document.querySelector('.checkmark');
        checkmark.classList.add('draw');
    }
    
    // Reset form
    function resetForm() {
        const activeForm = document.querySelector('.tab-content.active form');
        activeForm.reset();
        
        // Clear validation classes
        const inputs = activeForm.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.classList.remove('valid', 'invalid');
            input.parentElement.classList.remove('focused');
        });
        
        // Reset progress bar
        updateFormProgress(0);
        
        // Reset response message
        responseDiv.className = 'response-message';
        responseDiv.textContent = '';
        
        // Reset character counter if it exists
        if (activeForm.id === 'contactForm') {
            currentCount.textContent = '0';
            currentCount.style.color = '';
        }
    }
    
    // New form request after successful submission
    function newFormRequest() {
        successAnimation.style.display = 'none';
        resetForm();
    }
    
    // Save submission to local storage
    function saveSubmission(formData) {
        let submissions = JSON.parse(localStorage.getItem('formSubmissions')) || [];
        
        // Create a submission object
        const submission = {
            id: generateId(),
            type: formData.formType,
            name: formData.name || 'Anonymous',
            email: formData.email || '',
            subject: formData.subject || formData.feedbackType || 'Subscription',
            timestamp: new Date().toISOString()
        };
        
        // Add to beginning of array (most recent first)
        submissions.unshift(submission);
        
        // Keep only the last 5 submissions
        submissions = submissions.slice(0, 5);
        
        // Save to local storage
        localStorage.setItem('formSubmissions', JSON.stringify(submissions));
    }
    
    // Display recent submissions from local storage
    function displayRecentSubmissions() {
        const submissions = JSON.parse(localStorage.getItem('formSubmissions')) || [];
        
        if (submissions.length === 0) {
            submissionsList.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No recent submissions</p>
                </div>
            `;
            return;
        }
        
        submissionsList.innerHTML = '';
        
        submissions.forEach(submission => {
            const date = new Date(submission.timestamp);
            const formattedDate = `${date.toLocaleDateString()} at ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
            
            const submissionItem = document.createElement('div');
            submissionItem.className = 'submission-item';
            submissionItem.innerHTML = `
                <div class="submission-header">
                    <span class="submission-name">${escapeHTML(submission.name)}</span>
                    <span class="submission-time">${formattedDate}</span>
                </div>
                <div class="submission-email">${escapeHTML(submission.email)}</div>
                <span class="submission-type">${getFormTypeName(submission.type)}</span>
            `;
            
            submissionsList.appendChild(submissionItem);
        });
    }
    
    // Helper function to get form type display name
    function getFormTypeName(formType) {
        switch (formType) {
            case 'contactForm':
                return 'Contact';
            case 'subscriptionForm':
                return 'Subscription';
            case 'feedbackForm':
                return 'Feedback';
            default:
                return 'Other';
        }
    }
    
    // Generate a simple ID for submissions
    function generateId() {
        return Math.random().toString(36).substr(2, 9);
    }
    
    // Escape HTML for security (prevent XSS)
    function escapeHTML(str) {
        if (!str) return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
    
    // Initial display of recent submissions
    displayRecentSubmissions();
});