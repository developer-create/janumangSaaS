<div class="content-wrapper">
    <section class="content-header"><h1><i class="fa fa-plus"></i> डीपी समिति जोड़ें</h1></section>
    <section class="content">
        <div class="row"><div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">विवरण भरें</h3></div>
                <form action="<?php echo base_url('dpsamiti/store'); ?>" method="post">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>क्र.</label><input type="text" name="serial_number" class="form-control" required></div></div>
                            <div class="col-md-4"><div class="form-group"><label>वर्ष</label>
                                <select name="year" class="form-control" required>
                                    <option value="">Year</option>
                                    <?php foreach(['2020','2021','2022','2023','2024','2025','2026'] as $y){ echo '<option value="'.$y.'">'.$y.'</option>'; } ?>
                                </select>
                            </div></div>
                            <div class="col-md-4"><div class="form-group"><label>डीपी समिति का नाम</label>
                                <select name="dp_samiti_name" id="dp_samiti_name" class="form-control" required>
                                    <option value="">डीपी समिति चुनें</option>
                                    <?php if(!empty($names)) foreach($names as $n){ echo '<option value="'.$n->name.'">'.$n->name.'</option>'; } ?>
                                    <option value="__add_new__">+ नया जोड़ें</option>
                                </select>
                            </div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>ब्लॉक</label>
                                <select name="block_name" class="form-control" required>
                                    <option value="">Block</option>
                                    <?php foreach(['बाग','टांडा','गंधवानी','तिरला'] as $b){ echo '<option value="'.$b.'">'.$b.'</option>'; } ?>
                                </select>
                            </div></div>
                            <div class="col-md-4"><div class="form-group"><label>सेक्टर</label><input type="text" name="sector" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>माइक्रो सेक्टर नंबर</label><input type="text" name="micro_sector_number" class="form-control"></div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>माइक्रो सेक्टर नाम</label><input type="text" name="micro_sector_name" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>बूथ नंबर</label><input type="text" name="booth_number" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>बूथ नाम</label><input type="text" name="booth_name" class="form-control"></div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>पंचायत</label><input type="text" name="panchayat" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>ग्राम</label><input type="text" name="gram" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>फलिया</label><input type="text" name="faliya" class="form-control"></div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>सदस्य का नाम</label><input type="text" name="member_name" class="form-control"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>पिता का नाम</label><input type="text" name="father_name" class="form-control"></div></div>
                            <div class="col-md-2"><div class="form-group"><label>उम्र</label><input type="number" name="age" class="form-control"></div></div>
                            <div class="col-md-2"><div class="form-group"><label>पद</label><input type="text" name="position" class="form-control"></div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>मोबाइल नंबर</label><input type="text" name="mobile_number" class="form-control"></div></div>
                            <div class="col-md-8"><div class="form-group"><label>रिमार्क</label><textarea name="remark" rows="2" class="form-control"></textarea></div></div>
                        </div>
                    </div>
                    <div class="box-footer"><button type="submit" class="btn btn-primary">Submit</button> <a href="<?php echo base_url('dpsamiti'); ?>" class="btn btn-default">Cancel</a></div>
                </form>
            </div>
        </div></div>
    </section>
</div>

<script>
document.getElementById('dp_samiti_name').addEventListener('change', function(){
    if(this.value==='__add_new__'){
        var txt = prompt('नई डीपी समिति का नाम दर्ज करें');
        if(txt && txt.trim().length){
            var val = txt.trim();
            var idx = this.options.length - 1; var opt = new Option(val, val); this.add(opt, idx); this.value = val;
        } else { this.value=''; }
    }
});
</script>

