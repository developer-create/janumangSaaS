<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ब्लॉक समिति (Block Samiti) Details</h3>
                        <div class="box-tools">
                            <a href="<?php echo site_url('blocksamiti'); ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            <a href="<?php echo site_url('blocksamiti/edit/'.$record['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">क्र. (Serial No)</th>
                                    <td><?php echo $record['serial_no']; ?></td>
                                </tr>
                                <tr>
                                    <th>ब्लॉक (Block)</th>
                                    <td><?php echo $record['block']; ?></td>
                                </tr>
                                <tr>
                                    <th>सेक्टर (Sector)</th>
                                    <td><?php echo $record['sector']; ?></td>
                                </tr>
                                <tr>
                                    <th>माइक्रो सेक्टर न (Micro Sector No)</th>
                                    <td><?php echo $record['micro_sector_no']; ?></td>
                                </tr>
                                <tr>
                                    <th>माइक्रो सेक्टर नाम (Micro Sector Name)</th>
                                    <td><?php echo $record['micro_sector_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>बूथ का नाम (Booth Name)</th>
                                    <td><?php echo $record['booth_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>बूथ क (Booth No)</th>
                                    <td><?php echo $record['booth_no']; ?></td>
                                </tr>
                                <tr>
                                    <th>ग्राम पंचायत (Gram Panchayat)</th>
                                    <td><?php echo $record['gram_panchayat']; ?></td>
                                </tr>
                                <tr>
                                    <th>गांव का नाम (Village Name)</th>
                                    <td><?php echo $record['village']; ?></td>
                                </tr>
                                <tr>
                                    <th>फलिया (Faliya)</th>
                                    <td><?php echo $record['faliya']; ?></td>
                                </tr>
                                <tr>
                                    <th>सदस्य का नाम (Member Name)</th>
                                    <td><?php echo $record['member_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>पिता का नाम (Father Name)</th>
                                    <td><?php echo $record['father_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>उम्र (Age)</th>
                                    <td><?php echo $record['age']; ?></td>
                                </tr>
                                <tr>
                                    <th>पद (Position)</th>
                                    <td><?php echo $record['position']; ?></td>
                                </tr>
                                <tr>
                                    <th>मोबाइल नम्बर (Mobile Number)</th>
                                    <td><?php echo $record['mobile_number']; ?></td>
                                </tr>
                                <tr>
                                    <th>रिमार्क (Remark)</th>
                                    <td><?php echo $record['remark']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
