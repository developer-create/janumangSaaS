<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-user-circle-o" aria-hidden="true"></i> Voter Details</h1>
    </section>
    <section class="content">
        <?php
        $this->load->helper('url');
        $error = $this->session->flashdata('error');
        if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Profile</h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo site_url('voter'); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                    <a href="<?php echo site_url('voter/edit/' . $voter['id']); ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div style="border:1px solid #ddd;padding:10px;border-radius:4px;">
                            <?php if (!empty($voter['voter_image'])): ?>
                                <img src="<?php echo base_url('uploads/voters/' . $voter['voter_image']); ?>" alt="Voter Image" style="max-width:100%;height:auto;" />
                            <?php else: ?>
                                <div class="text-muted" style="padding:40px 0;">No Image</div>
                            <?php endif; ?>
                        </div>
                        <h4 style="margin-top:15px;">#<?php echo $voter['voter_id_epic']; ?></h4>
                    </div>
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width:200px;">Name</th>
                                        <td><?php echo $voter['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Father Name</th>
                                        <td><?php echo $voter['father_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile No</th>
                                        <td><?php echo $voter['mobile_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Age</th>
                                        <td><?php echo $voter['age']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cast</th>
                                        <td><?php echo !empty($voter['cast']) ? $voter['cast'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sub-Cast</th>
                                        <td><?php echo !empty($voter['sub_cast']) ? $voter['sub_cast'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Full Address</th>
                                        <td><?php echo $voter['full_address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Block</th>
                                        <td><?php echo !empty($voter['block_name']) ? $voter['block_name'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Booth</th>
                                        <td><?php echo !empty($voter['booth_name']) ? $voter['booth_name'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Booth No</th>
                                        <td><?php echo !empty($voter['booth_no']) ? $voter['booth_no'] : (!empty($voter['booth_number']) ? $voter['booth_number'] : '<span class="text-muted">N/A</span>'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Panchayat</th>
                                        <td><?php echo !empty($voter['panchayat_name']) ? $voter['panchayat_name'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Village</th>
                                        <td><?php echo !empty($voter['village_name']) ? $voter['village_name'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Falia / Majra</th>
                                        <td><?php echo !empty($voter['falia_majra']) ? $voter['falia_majra'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created On</th>
                                        <td><?php echo !empty($voter['created_on']) ? $voter['created_on'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Updated On</th>
                                        <td><?php echo !empty($voter['updated_on']) ? $voter['updated_on'] : '<span class="text-muted">N/A</span>'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .content-header h1 { font-size:22px; }
    .table th { background:#f9f9f9; }
</style>