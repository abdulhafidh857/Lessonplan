// Enhanced Lesson Plan System - JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the application
    initializeApp();
});

/**
 * Initialize the application
 */
function initializeApp() {
    // Add smooth transitions to buttons
    addButtonInteractions();
    
    // Auto-save form data
    initializeAutoSave();
    
    // Add search functionality
    initializeSearch();
    
    // Add form validation
    initializeFormValidation();
    
    // Add keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Add loading states
    initializeLoadingStates();
}

/**
 * Add interactive effects to buttons
 */
function addButtonInteractions() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        button.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(0)';
        });
        
        button.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-1px)';
        });
    });
}

/**
 * Initialize auto-save functionality for forms
 */
function initializeAutoSave() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            const key = `autosave_${input.name || input.id}`;
            
            // Load saved data
            const savedValue = localStorage.getItem(key);
            if (savedValue && input.value === '') {
                input.value = savedValue;
                showAutoSaveNotification('Restored auto-saved data');
            }
            
            // Save data on input
            input.addEventListener('input', function() {
                localStorage.setItem(key, this.value);
                showAutoSaveIndicator();
            });
        });
        
        // Clear auto-save data on successful form submission
        form.addEventListener('submit', function() {
            inputs.forEach(input => {
                const key = `autosave_${input.name || input.id}`;
                localStorage.removeItem(key);
            });
        });
    });
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const filterSelect = document.querySelector('.filter-select');
    
    if (searchInput) {
        // Add search icon animation
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
        
        // Real-time search (debounced)
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Could implement real-time filtering here
                console.log('Searching for:', this.value);
            }, 300);
        });
    }
    
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            // Could implement real-time filtering here
            console.log('Filtering by:', this.value);
        });
    }
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showValidationErrors();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });
    });
}

/**
 * Validate a single form field
 */
function validateField(field) {
    const isValid = field.checkValidity();
    
    if (isValid) {
        field.classList.remove('error');
        removeFieldError(field);
    } else {
        field.classList.add('error');
        showFieldError(field);
    }
    
    return isValid;
}

/**
 * Validate entire form
 */
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Show field-specific error
 */
function showFieldError(field) {
    removeFieldError(field); // Remove existing error
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = field.validationMessage || 'This field is required';
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

/**
 * Remove field error
 */
function removeFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

/**
 * Show validation errors summary
 */
function showValidationErrors() {
    showNotification('Please correct the errors below', 'error');
}

/**
 * Initialize keyboard shortcuts
 */
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const saveButton = document.querySelector('button[type="submit"]');
            if (saveButton) {
                saveButton.click();
            }
        }
        
        // Ctrl/Cmd + N to create new
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const createLink = document.querySelector('a[href="create.php"]');
            if (createLink) {
                window.location.href = createLink.href;
            }
        }
        
        // Escape to go back
        if (e.key === 'Escape') {
            const backButton = document.querySelector('a[href*="index.php"]');
            if (backButton) {
                window.location.href = backButton.href;
            }
        }
    });
}

/**
 * Initialize loading states
 */
function initializeLoadingStates() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitButton.disabled = true;
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 5000);
            }
        });
    });
}

/**
 * Show auto-save notification
 */
function showAutoSaveNotification(message) {
    showNotification(message, 'info', 2000);
}

/**
 * Show auto-save indicator
 */
function showAutoSaveIndicator() {
    // Create or update auto-save indicator
    let indicator = document.querySelector('.autosave-indicator');
    
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.className = 'autosave-indicator';
        indicator.style.position = 'fixed';
        indicator.style.top = '20px';
        indicator.style.right = '20px';
        indicator.style.background = '#10b981';
        indicator.style.color = 'white';
        indicator.style.padding = '8px 16px';
        indicator.style.borderRadius = '6px';
        indicator.style.fontSize = '0.875rem';
        indicator.style.zIndex = '1000';
        indicator.style.opacity = '0';
        indicator.style.transition = 'opacity 0.3s ease';
        document.body.appendChild(indicator);
    }
    
    indicator.textContent = '✓ Auto-saved';
    indicator.style.opacity = '1';
    
    // Hide after 2 seconds
    setTimeout(() => {
        indicator.style.opacity = '0';
    }, 2000);
}

/**
 * Show notification
 */
function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '16px 20px';
    notification.style.borderRadius = '8px';
    notification.style.fontSize = '0.875rem';
    notification.style.fontWeight = '500';
    notification.style.zIndex = '1001';
    notification.style.opacity = '0';
    notification.style.transform = 'translateX(100%)';
    notification.style.transition = 'all 0.3s ease';
    notification.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    
    // Set colors based on type
    const colors = {
        info: { bg: '#3b82f6', text: 'white' },
        success: { bg: '#10b981', text: 'white' },
        error: { bg: '#ef4444', text: 'white' },
        warning: { bg: '#f59e0b', text: 'white' }
    };
    
    const color = colors[type] || colors.info;
    notification.style.background = color.bg;
    notification.style.color = color.text;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, duration);
}

/**
 * Confirm delete action
 */
function confirmDelete(message = 'Are you sure you want to delete this item?') {
    return confirm(message);
}

/**
 * Format text areas for better UX
 */
function initializeTextAreas() {
    const textAreas = document.querySelectorAll('textarea');
    
    textAreas.forEach(textArea => {
        // Auto-resize
        textArea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
        
        // Tab support
        textArea.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                
                this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 1;
            }
        });
    });
}

/**
 * Add smooth scrolling to anchor links
 */
function initializeSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Initialize tooltips for better UX
 */
function initializeTooltips() {
    const elementsWithTooltips = document.querySelectorAll('[title]');
    
    elementsWithTooltips.forEach(element => {
        const title = element.getAttribute('title');
        element.removeAttribute('title'); // Remove default tooltip
        
        let tooltip;
        
        element.addEventListener('mouseenter', function(e) {
            tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = title;
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#1f2937';
            tooltip.style.color = 'white';
            tooltip.style.padding = '6px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '0.875rem';
            tooltip.style.zIndex = '1002';
            tooltip.style.pointerEvents = 'none';
            tooltip.style.opacity = '0';
            tooltip.style.transition = 'opacity 0.2s ease';
            
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
            
            setTimeout(() => {
                if (tooltip) tooltip.style.opacity = '1';
            }, 100);
        });
        
        element.addEventListener('mouseleave', function() {
            if (tooltip) {
                tooltip.style.opacity = '0';
                setTimeout(() => {
                    if (tooltip && tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                    }
                }, 200);
            }
        });
    });
}

// Initialize additional features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeTextAreas();
    initializeSmoothScrolling();
    initializeTooltips();
});

// Export functions for global use
window.LessonPlanSystem = {
    showNotification,
    confirmDelete,
    validateForm,
    validateField
};