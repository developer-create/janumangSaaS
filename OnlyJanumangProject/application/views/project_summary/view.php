<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-eye" aria-hidden="true"></i> View Project
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Project Details</h3>
                        <div class="box-tools">
                            <a class="btn btn-default" href="<?php echo base_url(); ?>projectSummary/projectListing"><i class="fa fa-arrow-left"></i> Back to List</a>
                            <a class="btn btn-primary" href="<?php echo base_url().'projectSummary/edit/'.(int)$projectInfo->id; ?>"><i class="fa fa-pencil"></i> Edit</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;">Work Name</th>
                                    <td><?php echo htmlspecialchars($projectInfo->work_name); ?></td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td><?php echo htmlspecialchars($projectInfo->district_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Block</th>
                                    <td><?php echo htmlspecialchars($projectInfo->block_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td><?php echo htmlspecialchars($projectInfo->department_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Project Cost</th>
                                    <td>₹<?php echo number_format((float)$projectInfo->amount_project_cost, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Proposal Estimate</th>
                                    <td>₹<?php echo number_format((float)$projectInfo->proposal_estimate, 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo htmlspecialchars($projectInfo->status); ?></td>
                                </tr>
                                <tr>
                                    <th>Officer Name</th>
                                    <td><?php echo htmlspecialchars($projectInfo->officer_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td><?php echo htmlspecialchars($projectInfo->contact_no); ?></td>
                                </tr>
                                <tr>
                                    <th>Technical Session</th>
                                    <td><?php echo !empty($projectInfo->technical_session) ? htmlspecialchars($projectInfo->technical_session) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Administrative Session</th>
                                    <td><?php echo !empty($projectInfo->administrative_session) ? htmlspecialchars($projectInfo->administrative_session) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Tender Status</th>
                                    <td>
                                        <?php 
                                        if(!empty($projectInfo->tender_status)) {
                                            $tender_class = ($projectInfo->tender_status == 'Open') ? 'label-success' : (($projectInfo->tender_status == 'Pending') ? 'label-warning' : 'label-danger');
                                            echo '<span class="label ' . $tender_class . '">' . htmlspecialchars($projectInfo->tender_status) . '</span>';
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Company Name</th>
                                    <td><?php echo !empty($projectInfo->company_name) ? htmlspecialchars($projectInfo->company_name) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Contractor Name</th>
                                    <td><?php echo !empty($projectInfo->contractor_name) ? htmlspecialchars($projectInfo->contractor_name) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Phone No</th>
                                    <td><?php echo !empty($projectInfo->phone_no) ? htmlspecialchars($projectInfo->phone_no) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>USD Remark</th>
                                    <td style="white-space: normal; word-break: break-word;"><?php echo !empty($projectInfo->usd_remark) ? nl2br(htmlspecialchars($projectInfo->usd_remark)) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Created Date</th>
                                    <td><?php echo !empty($projectInfo->created_at) ? date("d-m-Y H:i", strtotime($projectInfo->created_at)) : 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <th>Updated Date</th>
                                    <td><?php echo !empty($projectInfo->updated_at) ? date("d-m-Y H:i", strtotime($projectInfo->updated_at)) : 'N/A'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


