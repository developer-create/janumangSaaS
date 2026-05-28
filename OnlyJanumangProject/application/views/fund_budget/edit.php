<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Fund Budget</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Details</h3>
                        <a href="<?php echo site_url('fundBudget'); ?>" class="btn btn-default btn-sm" style="float:right;">Back</a>
                    </div>
                    <?php echo form_open('fundBudget/update'); ?>
                    <input type="hidden" name="id" value="<?php echo (int) $row['id']; ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Financial Year</label>
                            <select name="financial_year" class="form-control" required>
                                <?php krsort($financial_years);
                                foreach ($financial_years as $fy): ?>
                                    <option value="<?php echo htmlspecialchars($fy); ?>" <?php echo ($row['financial_year'] === $fy) ? 'selected' : ''; ?>><?php echo htmlspecialchars($fy); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fund</label>
                            <select name="fund_key" class="form-control" required>
                                <?php foreach ($fund_keys as $fk): ?>
                                    <option value="<?php echo htmlspecialchars($fk); ?>" <?php echo ($row['fund_key'] === $fk) ? 'selected' : ''; ?>><?php echo htmlspecialchars(isset($fund_labels[$fk]) ? $fund_labels[$fk] : $fk); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Total Amount (₹)</label>
                            <input type="number" name="total_amount" class="form-control" step="0.01" min="0" required value="<?php echo htmlspecialchars($row['total_amount']); ?>">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
