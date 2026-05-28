<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-eye"></i> टैंकर समिति विवरण</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-title">विवरण</h3></div>
                    <div class="box-body">
                        <?php if(!empty($row)) { ?>
                        <table class="table table-bordered">
                            <tr><th>क्र.</th><td><?php echo $row['serial_number']; ?></td></tr>
                            <tr><th>वर्ष</th><td><?php echo $row['year']; ?></td></tr>
                            <tr><th>टैंकर समिति का नाम</th><td><?php echo $row['tenkar_samiti_name']; ?></td></tr>
                            <tr><th>ब्लॉक</th><td><?php echo $row['block_name']; ?></td></tr>
                            <tr><th>सेक्टर</th><td><?php echo $row['sector']; ?></td></tr>
                            <tr><th>माइक्रो सेक्टर नंबर</th><td><?php echo $row['micro_sector_number']; ?></td></tr>
                            <tr><th>माइक्रो सेक्टर नाम</th><td><?php echo $row['micro_sector_name']; ?></td></tr>
                            <tr><th>बूथ नंबर</th><td><?php echo $row['booth_number']; ?></td></tr>
                            <tr><th>बूथ नाम</th><td><?php echo $row['booth_name']; ?></td></tr>
                            <tr><th>पंचायत</th><td><?php echo $row['panchayat']; ?></td></tr>
                            <tr><th>ग्राम</th><td><?php echo $row['gram']; ?></td></tr>
                            <tr><th>फलिया</th><td><?php echo $row['faliya']; ?></td></tr>
                            <tr><th>सदस्य का नाम</th><td><?php echo $row['member_name']; ?></td></tr>
                            <tr><th>पिता का नाम</th><td><?php echo $row['father_name']; ?></td></tr>
                            <tr><th>उम्र</th><td><?php echo $row['age']; ?></td></tr>
                            <tr><th>पद</th><td><?php echo $row['position']; ?></td></tr>
                            <tr><th>मोबाइल नंबर</th><td><?php echo $row['mobile_number']; ?></td></tr>
                            <tr><th>रिमार्क</th><td><?php echo $row['remark']; ?></td></tr>
                            <tr><th>तैयार</th><td><?php echo $row['created_on']; ?></td></tr>
                            <tr><th>अपडेट</th><td><?php echo $row['updated_on']; ?></td></tr>
                        </table>
                        <?php } else { echo '<p>No record found.</p>'; } ?>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo base_url('tenkarsamiti'); ?>" class="btn btn-default">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

