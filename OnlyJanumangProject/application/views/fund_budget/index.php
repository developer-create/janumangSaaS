<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-sliders"></i> Fund Budget Limits (By Financial Year)</h1>
        <small>MLA FUND, Swecha Nidhi, CLP Fund, Jansampark — Set total amount here</small>
    </section>
    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Budget List</h3>
                        <a href="<?php echo site_url('fundBudget/add'); ?>" class="btn btn-success" style="float:right;">Add New</a>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Financial Year</th>
                                    <th>Fund</th>
                                    <th>Total Amount (₹)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($rows)): ?>
                                    <tr><td colspan="4">No records found. Please add new.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($rows as $r): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($r['financial_year']); ?></td>
                                            <td><?php echo htmlspecialchars(isset($fund_labels[$r['fund_key']]) ? $fund_labels[$r['fund_key']] : $r['fund_key']); ?></td>
                                            <td><?php echo number_format((float) $r['total_amount'], 2); ?></td>
                                            <td>
                                                <a href="<?php echo site_url('fundBudget/edit/' . (int) $r['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                                <a href="<?php echo site_url('fundBudget/delete/' . (int) $r['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
