/**
 * FormPersistence Utility
 * Automatically save and restore form data to/from localStorage
 * Handles form errors gracefully and persists data across sessions
 */

class FormPersistence {
    /**
     * Initialize FormPersistence for a form
     * @param {string} formId - The ID of the form to persist
     * @param {object} options - Configuration options
     */
    static init(formId, options = {}) {
        const form = document.getElementById(formId);
        if (!form) {
            console.warn(`FormPersistence: Form with ID '${formId}' not found`);
            return;
        }

        const storageKey = options.storageKey || `form_${formId}`;
        const autoSaveDelay = options.autoSaveDelay || 300; // milliseconds

        // Restore form data on page load
        this.restoreFormData(form, storageKey);

        // Setup auto-save on input change
        let saveTimeout;
        form.addEventListener('input', () => {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                this.saveFormData(form, storageKey);
            }, autoSaveDelay);
        });

        form.addEventListener('change', () => {
            this.saveFormData(form, storageKey);
        });

        // Clear saved data on successful form submission
        form.addEventListener('submit', (e) => {
            // Only clear if form is valid (no errors shown)
            setTimeout(() => {
                if (!form.querySelector('[role="alert"]')) {
                    this.clearFormData(storageKey);
                }
            }, 100);
        });
    }

    /**
     * Save form data to localStorage
     * @param {HTMLFormElement} form - The form to save
     * @param {string} storageKey - The localStorage key
     */
    static saveFormData(form, storageKey) {
        const formData = new FormData(form);
        const data = {};

        // Save all form fields
        for (let [key, value] of formData.entries()) {
            if (!data[key]) {
                data[key] = value;
            } else if (Array.isArray(data[key])) {
                data[key].push(value);
            } else {
                data[key] = [data[key], value];
            }
        }

        // Also save textarea values
        form.querySelectorAll('textarea').forEach(textarea => {
            data[textarea.name] = textarea.value;
        });

        try {
            localStorage.setItem(storageKey, JSON.stringify(data));
            console.log(`FormPersistence: Data saved to '${storageKey}'`);
        } catch (error) {
            console.error('FormPersistence: Error saving data', error);
        }
    }

    /**
     * Restore form data from localStorage
     * @param {HTMLFormElement} form - The form to restore
     * @param {string} storageKey - The localStorage key
     */
    static restoreFormData(form, storageKey) {
        try {
            const savedData = localStorage.getItem(storageKey);
            if (!savedData) return;

            const data = JSON.parse(savedData);

            for (let [key, value] of Object.entries(data)) {
                const fields = form.querySelectorAll(`[name="${key}"]`);

                if (fields.length === 0) continue;

                fields.forEach((field) => {
                    if (field.type === 'checkbox') {
                        field.checked = value === 'on' || value === true;
                    } else if (field.type === 'radio') {
                        if (field.value === value) {
                            field.checked = true;
                        }
                    } else {
                        field.value = value;
                    }

                    // Trigger change event to update dependent fields
                    field.dispatchEvent(new Event('change', { bubbles: true }));
                });
            }

            console.log(`FormPersistence: Data restored from '${storageKey}'`);
        } catch (error) {
            console.error('FormPersistence: Error restoring data', error);
        }
    }

    /**
     * Clear saved form data from localStorage
     * @param {string} storageKey - The localStorage key
     */
    static clearFormData(storageKey) {
        try {
            localStorage.removeItem(storageKey);
            console.log(`FormPersistence: Data cleared from '${storageKey}'`);
        } catch (error) {
            console.error('FormPersistence: Error clearing data', error);
        }
    }

    /**
     * Get saved form data without restoring to form
     * @param {string} storageKey - The localStorage key
     * @returns {object} The saved data
     */
    static getSavedData(storageKey) {
        try {
            const savedData = localStorage.getItem(storageKey);
            return savedData ? JSON.parse(savedData) : null;
        } catch (error) {
            console.error('FormPersistence: Error getting saved data', error);
            return null;
        }
    }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormPersistence;
}
