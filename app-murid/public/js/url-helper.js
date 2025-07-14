/**
 * Global URL Helper for SIMAKLAH App Murid
 * Automatically fixes all URLs to use current port
 */

// URL Helper Object
window.SimaklahUrlHelper = {
    currentUrl: '',
    
    init: function(currentUrl) {
        this.currentUrl = currentUrl || this.detectCurrentUrl();
        this.fixAllUrls();
        
        // Watch for dynamically added content
        this.observeChanges();
    },
    
    detectCurrentUrl: function() {
        return window.location.protocol + '//' + window.location.host;
    },
    
    fixAllUrls: function() {
        if (!this.currentUrl) return;
        
        // Fix navigation links
        this.fixLinks();
        
        // Fix form actions
        this.fixForms();
        
        // Fix AJAX URLs
        this.fixAjaxUrls();
    },
    
    fixLinks: function() {
        const links = document.querySelectorAll('a[href^="/"]');
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('/')) {
                link.setAttribute('href', this.currentUrl + href);
                link.setAttribute('data-original-href', href);
            }
        });
    },
    
    fixForms: function() {
        const forms = document.querySelectorAll('form[action^="/"]');
        forms.forEach(form => {
            const action = form.getAttribute('action');
            if (action && action.startsWith('/')) {
                form.setAttribute('action', this.currentUrl + action);
                form.setAttribute('data-original-action', action);
            }
        });
    },
    
    fixAjaxUrls: function() {
        // Store reference for AJAX calls
        window.ajaxUrl = (path) => {
            return this.currentUrl + (path.startsWith('/') ? path : '/' + path);
        };
        
        // Helper for fetch API
        window.fetchUrl = (path, options = {}) => {
            return fetch(this.currentUrl + (path.startsWith('/') ? path : '/' + path), options);
        };
    },
    
    observeChanges: function() {
        // Watch for new elements added to DOM
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1) { // Element node
                            this.fixNewElement(node);
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    },
    
    fixNewElement: function(element) {
        // Fix links in new element
        const links = element.querySelectorAll ? element.querySelectorAll('a[href^="/"]') : [];
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('/') && !link.hasAttribute('data-original-href')) {
                link.setAttribute('href', this.currentUrl + href);
                link.setAttribute('data-original-href', href);
            }
        });
        
        // Fix forms in new element
        const forms = element.querySelectorAll ? element.querySelectorAll('form[action^="/"]') : [];
        forms.forEach(form => {
            const action = form.getAttribute('action');
            if (action && action.startsWith('/') && !form.hasAttribute('data-original-action')) {
                form.setAttribute('action', this.currentUrl + action);
                form.setAttribute('data-original-action', action);
            }
        });
    },
    
    // Utility methods
    url: function(path) {
        return this.currentUrl + (path.startsWith('/') ? path : '/' + path);
    },
    
    redirect: function(path) {
        window.location.href = this.url(path);
    }
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Get current URL from PHP variable if available
    const currentUrl = window.phpCurrentUrl || SimaklahUrlHelper.detectCurrentUrl();
    SimaklahUrlHelper.init(currentUrl);
    
    console.log('SIMAKLAH URL Helper initialized with:', currentUrl);
});

// Legacy support for existing code
window.fixUrlPort = function(url) {
    return SimaklahUrlHelper.url(url);
};
