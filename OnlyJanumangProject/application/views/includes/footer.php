

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Design & Developed By</b> Jinpushp Infotech
        </div>
        <strong>Copyright &copy; 2024-2025 Jan Umang</a>.</strong> All rights reserved.
    </footer>
    
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    <script type="text/javascript">
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
        var x= $('a[href="'+pageURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
        var y= $('a[href="'+windowURL+'"]');
            y.addClass('active');
            y.parent().addClass('active');

        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable common shortcuts like Ctrl+C, Ctrl+U, Ctrl+S, F12
        document.onkeydown = function(e) {
            if (e.ctrlKey && 
                (e.keyCode === 67 || // Ctrl+C
                 e.keyCode === 86 || // Ctrl+V
                 e.keyCode === 85 || // Ctrl+U
                 e.keyCode === 83 || // Ctrl+S
                 e.keyCode === 117)) { // F12
                return false;
            } else if (e.keyCode === 123) { // F12
                return false;
            } else {
                return true;
            }
        };
    </script>
  </body>
</html>