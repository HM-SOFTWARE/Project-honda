<?php
$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'id' => 'infon-car-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<div class="col-md-12" style=" border-bottom: 1px solid #b71113"><h1>ລາຍ​ງານ​ລາຍ​ຮັບ​ລາຍ​ວັນ</h1></div>
&nbsp;
<div class="row" >
    <div class="col-md-6">
        ຈາກວັນ​ທີ: 
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'date_start',
            'value' => isset($_POST['date_start']) ? $_POST['date_start'] : "",
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2099',
                'minDate' => '2000-01-01', // minimum date
                'maxDate' => '2099-12-31', // maximum date
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>

        ຫາ 
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'date_end',
            'value' => isset($_POST['date_end']) ? $_POST['date_end'] : "",
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2099',
                'minDate' => '2000-01-01', // minimum date
                'maxDate' => '2099-12-31', // maximum date
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
    </div>
</div>
<div class="row">
</div>
<div class="row" style="padding-top: 5px;">
    <div class="col-md-3">
        ເລືອກ​ສາ​ຂາ <select name="branch" >
            <?php
            if (Yii::app()->user->checkAccess('Admin')) {
                $data = Branch::model()->findAll();
                echo '<option value>ທັງ​ໝົດ</option>';
            } else {
                $user = User::model()->findByPk(Yii::app()->user->id);
                $data = Branch::model()->findAll('id=' . $user->branch_id . '');
            }
            foreach ($data as $branchs) {
                ?>
                <option value="<?= $branchs->id ?>" <?= (isset($_POST['branch']) && $_POST['branch'] == $branchs->id) ? "selected" : "" ?>><?= $branchs->branch_name ?></option>
                <?php
            }
            ?>
        </select>

    </div>
    <div class="col-md-6">
        <button type="submit" name="search" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> ເບີ່ງ​ລາຍງານ</button>
    </div>
</div>
<br/>
<br/>
<?php $this->endWidget(); ?>
<div align="right" >
    <script>
        function getHtmlData()
        {
            $("#print_pdf").val('<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;">' + $("#pdf_export").clone().html() + '</table>');
            return true;
        }
    </script>

    <form method="post" action="<?= Yii::app()->baseUrl ?>/index.php?r=infonCar/ExportPdf&daily=1" onSubmit="javascript:return getHtmlData()">
        <input type="hidden" id="print_pdf" name="pdf" value="">  
        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-export"></span>ລາຍ​ງານ​ເປັນ PDF</button>
    </form>
</div>
<script>
    $(function () {
        $("body").tooltip({
            selector: '[data-toggle="tooltip"]',
            container: 'body'
        });
    })
</script>
<table class="table table-bordered" id="pdf_export" >
    <tr style="background-color: #006dcc">
        <th>ວັນ​ທີ</th>
        <th>ລາຍ​ຮັບ​ລວມ</th>
        <th>​ລາຍ​ຈ່າຍ​ລວມ</th>
        <th>​ລາ​ຍ​ຮັບສຸດ​ທີ</th>
        <th>ໝີ້​ຕ້ອງ​ຮັ​ບ</th>
        <th>ໝີ້​ຈ່າຍ​ເຂົ້າ</th>
        <th>​ເງີນ​ສົດ​ສຸດ​ທີ</th>
    </tr>
    <?php
    if (isset($_POST['search'])) {
        if (!empty($_POST['branch'])) {
            $branch = Branch::model()->findAll('id=' . $_POST['branch'] . '');
        } else {
            $branch = Branch::model()->findAll();
        }
        $total_recived_all = 0;
        $total_paid_all = 0;
        $total_recived_max_all = 0;
        $total_nitonghup_all = 0;
        $total_nitongpayin_all = 0;
        $total_real_recived_all = 0;
        foreach ($branch as $branchs) {
            ?>
            <tr style="background-color: #FFE495">
                <td colspan="7"><?= $branchs->branch_name ?></td>
            </tr>
            <?php
            $a = 0;
            $count_next = 0;
            $total_recived = 0;
            $total_paid = 0;
            $total_recived_max = 0;
            $total_nitonghup = 0;
            $total_nitongpayin = 0;
            $total_real_recived = 0;
            $arra = array();
            $startTime = strtotime($_POST['date_start']);
            $endTime = strtotime($_POST['date_end']);
            for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
                $a++;
                $date_loop = date('Y-m-d', $i);
                ?>
                <tr>
                    <td data-toggle="tooltip" title="ວັນ​ທີ"><?= date('Y-m-d', $i) ?></td>
                    <td data-toggle="tooltip" title="ລາຍ​ຮັບ​ລວມ">
                        <?php
                        $command_recieve_sale_car_cash = Yii::app()->db->createCommand('SELECT SUM(paid) FROM car_sale WHERE date="' . $date_loop . '" and branch_id=' . $branchs->id . ' and sale_status_id IN(1)')->queryScalar();
                        $command_car_discounts = Yii::app()->db->createCommand('SELECT DISTINCT customer_id FROM car_sale LEFT JOIN infon_car ON car_sale.infon_car_id=infon_car.id WHERE infon_car.date_out="' . $date_loop . '" and car_sale.branch_id=' . $branchs->id . ' and car_sale.sale_status_id IN(1,2)')->queryAll();
                        $command_discount_car_price = 0;
                        $command_recieve_sale_car_doa = 0;
                        foreach ($command_car_discounts as $command_car_discount) {
                            $command_recieve_sale_car_doa+= Yii::app()->db->createCommand('SELECT SUM(paid) FROM depts_month_pay WHERE customer_id="' . $command_car_discount['customer_id'] . '"')->queryScalar();
                            $min_id = Yii::app()->db->createCommand('SELECT id FROM car_sale WHERE customer_id="' . $command_car_discount['customer_id'] . '" and date<="' . $date_loop . '"')->queryAll();
                            $max_id = Yii::app()->db->createCommand('SELECT MAX(id) FROM car_sale WHERE customer_id="' . $command_car_discount['customer_id'] . '"')->queryScalar();
                            if (count($min_id) <= 1) { /// for sale have discount
                                $command_discount_car_price+= Yii::app()->db->createCommand('SELECT SUM(discount) FROM discount WHERE customer_id=' . $command_car_discount['customer_id'] . '')->queryScalar();
                            }
                        }
                        $recieve = ($command_recieve_sale_car_cash + $command_recieve_sale_car_doa) - $command_discount_car_price;
                        //  echo $command_recieve_sale_car_doa . "<br/>";
                        // echo $command_recieve_sale_car_cash . "<br/>";
                        //echo $command_recieve_sale_car_doa . "<br/>";
                        echo number_format(($recieve), 2);
                        $total_recived+=$recieve;
                        ?>
                    </td>
                    <td data-toggle="tooltip" title="​ລາຍ​ຈ່າຍ​ລວມ">
                        <?php
                        $command_payout = Yii::app()->db->createCommand('SELECT SUM(amonut) FROM payment_in WHERE date="' . $date_loop . '" and branch_id=' . $branchs->id . '')->queryScalar();
                        echo number_format($command_payout, 2);
                        $total_paid+=$command_payout;
                        ?>
                    </td>
                    <td data-toggle="tooltip" title="​ລາ​ຍ​ຮັບສຸດ​ທີ">
                        <?php
                        $recived_max = $recieve - $command_payout;
                        ?>
                        <?= number_format($recived_max, 2) ?>
                        <?php
                        $total_recived_max+=$recived_max;
                        ?>
                    </td>
                    <td data-toggle="tooltip" title="ໝີ້​ຕ້ອງ​ຮັ​ບ">
                        <?php
                        $command_car_dao = Yii::app()->db->createCommand('SELECT DISTINCT customer_id FROM car_sale LEFT JOIN infon_car ON car_sale.infon_car_id=infon_car.id WHERE infon_car.date_out="' . $date_loop . '" and car_sale.branch_id=' . $branchs->id . ' and car_sale.sale_status_id IN(2)')->queryAll();
                        $nitonghup = 0;
                        foreach ($command_car_dao as $command_car_daos) {
                            $nitonghup+= Yii::app()->db->createCommand('SELECT SUM(paid) FROM depts_month_pay WHERE customer_id="' . $command_car_daos['customer_id'] . '" and first_pay="N" and status="0"')->queryScalar();
                        }
                        $total_nitonghup+=$nitonghup;
                        echo number_format($nitonghup, 2);
                        ?>
                    </td>
                    <td data-toggle="tooltip" title="ໝີ້​ຈ່າຍ​ເຂົ້າ">
                        <?php
                        $command_car_dao = Yii::app()->db->createCommand('SELECT DISTINCT customer_id FROM car_sale LEFT JOIN infon_car ON car_sale.infon_car_id=infon_car.id WHERE infon_car.date_out="' . $date_loop . '" and car_sale.branch_id=' . $branchs->id . ' and car_sale.sale_status_id IN(2)')->queryAll();
                        $nipayin = 0;
                        foreach ($command_car_dao as $command_car_daos) {
                            $nipayin+= Yii::app()->db->createCommand('SELECT SUM(paid) FROM depts_month_pay WHERE customer_id="' . $command_car_daos['customer_id'] . '" and first_pay="N" and status="1"')->queryScalar();
                        }
                        $total_nitongpayin+=$nipayin;
                        echo number_format($nipayin, 2);
                        ?>
                    </td>
                    <td data-toggle="tooltip" title="​ເງີນ​ສົດ​ສຸດ​ທີ">
                        <?php
                        $real_recived = $recived_max - $nitonghup;
                        ?>
                        <?= number_format($real_recived, 2) ?>
                        <?php
                        $total_real_recived+=$real_recived;
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td><b>ລວມ​ຈຳ​ນວນເງີນ</b></td>
                <td><b><?= number_format($total_recived, 2) ?></b></td>
                <td><b><?= number_format($total_paid, 2) ?></b></td>
                <td><b><?= number_format($total_recived_max, 2) ?></b></td>
                <td><b><?= number_format($total_nitonghup, 2) ?></b></td>
                <td><b><?= number_format($total_nitongpayin, 2) ?></b></td>
                <td><b><?= number_format($total_real_recived, 2) ?></b></td>
            </tr>
            <?php
            $total_recived_all+=$total_recived;
            $total_paid_all+=$total_paid;
            $total_recived_max_all+= $total_recived_max;
            $total_nitonghup_all+=$total_nitonghup;
            $total_nitongpayin_all+=$total_nitongpayin;
            $total_real_recived_all+=$total_real_recived;
        }
        if (count($branch) > 1) {
            ?>

            <tr>
                <td><b>ລວມ​ຈຳ​ນວນເງີນທັງ​ໝົດ</b></td>
                <td><b><?= number_format($total_recived_all, 2) ?></b></td>
                <td><b><?= number_format($total_paid_all, 2) ?></b></td>
                <td><b><?= number_format($total_recived_max_all, 2) ?></b></td>
                <td><b><?= number_format($total_nitonghup_all, 2) ?></b></td>
                <td><b><?= number_format($total_nitongpayin_all, 2) ?></b></td>
                <td><b><?= number_format($total_real_recived_all, 2) ?></b></td>
            </tr>
            <?php
        }
    }
    ?>
</table>
