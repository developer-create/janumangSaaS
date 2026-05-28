<div class="content-wrapper">
    <section class="content-header"> 
      <h1>
        <i class="fa fa-check-circle" aria-hidden="true"></i> Event Approvals
      </h1>
    </section>
    
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible" style="margin: 15px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible" style="margin: 15px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php endif; ?>
    
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pending Events for Approval</h3>
                    <div style="float: right;">
                        <a href="<?php echo site_url('events'); ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Back to Events
                        </a>
                    </div>
                </div>
                
                <div class="box-body table-responsive no-padding">
                    <?php if (empty($pending_events)): ?>
                    <div style="padding: 20px; text-align: center; color: #999;">
                        <i class="fa fa-check-circle" style="font-size: 48px; margin-bottom: 10px;"></i>
                        <p>No pending events for approval</p>
                    </div>
                    <?php else: ?>
                    <table class="table table-hover">
                        <thead>
                            <tr style="color:white;font-size:15px;background-color:#020254;">
                                <th>Sr No</th>
                                <th>Unique ID</th>
                                <th>Event Name</th>
                                <th>District</th>
                                <th>Block</th>
                                <th>Event Type</th>
                                <th>Program Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_events as $key => $event): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo isset($event['unique_id']) ? $event['unique_id'] : 'N/A'; ?></td>
                                <td><?php echo isset($event['name']) ? $event['name'] : 'N/A'; ?></td>
                                <td><?php 
                                    $districtValue = $event['district'];
                                    $districtDisplay = $districtValue;
                                    if (is_numeric($districtValue)) {
                                        $districtDisplay = 'N/A';
                                        foreach ($districts as $district) {
                                            if ($district['id'] == $districtValue) {
                                                $districtDisplay = $district['name'];
                                                break;
                                            }
                                        }
                                    }
                                    echo $districtDisplay;
                                ?></td>
                                <td><?php 
                                    $blockId = $event['block'];
                                    $blockName = 'N/A';
                                    foreach ($blocks as $block) {
                                        if ($block->id == $blockId) {
                                            $blockName = $block->name;
                                            break;
                                        }
                                    }
                                    echo $blockName;
                                ?></td>
                                <td><?php echo isset($event['event_type']) ? $event['event_type'] : 'N/A'; ?></td>
                                <td><?php echo isset($event['program_date']) ? $event['program_date'] : 'N/A'; ?></td>
                                <td><?php 
                                    $uid = $event['created_by'];
                                    if ($uid) {
                                        $cc = $this->db->query("SELECT * FROM `tbl_users` WHERE `userId`='$uid'");
                                        $Uu = $cc->row();
                                        if ($Uu) {
                                            echo $Uu->name;
                                        }
                                    }
                                ?></td>
                                <td><?php echo isset($event['created_at']) ? $event['created_at'] : 'N/A'; ?></td>
                                <td>
                                    <a href="<?php echo site_url('events/edit/'.$event['id']); ?>" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a href="<?php echo site_url('events/approve/'.$event['id']); ?>" class="btn btn-sm btn-success" title="Approve">
                                        <i class="fa fa-check"></i> Approve
                                    </a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal<?php echo $event['id']; ?>" title="Reject">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal<?php echo $event['id']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Event</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="<?php echo site_url('events/reject/'.$event['id']); ?>">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Rejection Reason:</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="4" placeholder="Enter reason for rejection..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject Event</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
              </div>
            </div>
        </div>
    </section> 
</div>
