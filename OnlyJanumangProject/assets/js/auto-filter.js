/**
 * Auto-Filter Functionality
 * Automatically applies filters on page load without requiring button click
 */

jQuery(document).ready(function() {
    // Auto-submit filter form on page load if any filter values are present
    var filterForm = jQuery('#filterForm');
    
    if (filterForm.length > 0) {
        // Add auto-submit on filter change
        filterForm.find('select[name^="filter_"], input[name^="filter_"]').on('change', function() {
            // Auto-submit the form when any filter changes
            filterForm.submit();
        });
    }
});
