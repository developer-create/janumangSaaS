<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-info-circle" aria-hidden="true"></i> View Kabbadi Samiti Details
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Location Information: <?php echo $group['unique_id']; ?></h3>
                        <div class="box-tools">
                            <a href="<?php echo site_url('kabbadisamiti'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Year:</strong> <?php echo $group['year']; ?></p>
                                <p><strong>AC/MP No.:</strong> <?php echo $group['ac_mp_no']; ?></p>
                                <p><strong>Block:</strong> <?php echo $group['block']; ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Sector:</strong> <?php echo $group['sector']; ?></p>
                                <p><strong>Micro Sector:</strong> <?php echo $group['micro_sector_no']; ?> - <?php echo $group['micro_sector_name']; ?></p>
                                <p><strong>Booth:</strong> <?php echo $group['booth_no']; ?> - <?php echo $group['booth_name']; ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Gram Panchayat:</strong> <?php echo $group['gram_panchayat']; ?></p>
                                <p><strong>Village:</strong> <?php echo $group['village']; ?></p>
                                <p><strong>Faliya:</strong> <?php echo $group['faliya']; ?></p>
                            </div>
                        </div>
                        <?php if(!empty($group['file_upload'])): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <p><strong>Attached File:</strong> 
                                        <a href="<?php echo base_url('uploads/kabbadisamiti/'.$group['file_upload']); ?>" target="_blank" class="btn btn-info btn-xs">
                                            <i class="fa fa-download"></i> Download / View File
                                        </a>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Members List</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background-color: #f4f4f4;">
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Father's Name</th>
                                    <th>Age</th>
                                    <th>Position</th>
                                    <th>Mobile</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($members)): ?>
                                    <?php foreach ($members as $key => $member): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $member['member_name']; ?></td>
                                        <td><?php echo $member['father_name']; ?></td>
                                        <td><?php echo $member['age']; ?></td>
                                        <td><?php echo $member['position']; ?></td>
                                        <td><?php echo $member['mobile_number']; ?></td>
                                        <td><?php echo $member['remark']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No members found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
