<?php

$bill = App\Models\Billing::where('event_id',$event->id)->first();

$pay = App\Models\PaymentLogs::where('event_id',$event->id)->get();
$paymentinfo = App\Models\PaymentInfo::where('event_id',$event->id)->orderBy('id', 'desc')->first();
$info = App\Models\PaymentInfo::where('event_id',$event->id)->get();
$total = 0;
$latefee = 0;
$adjustments = 0;
foreach($info as $inf){
$latefee += $inf->latefee;
$adjustments += $inf->adjustments;
}
foreach($pay as $p){
$total += $p->amount;
}
?>
<?php if($event->status == 3): ?>
<?php echo e(Form::open(array('route' => ['billing.paymentinfoupdate', urlencode(encrypt($event->id))],'method'=>'post','enctype'=>'multipart/form-data'))); ?>

    <div class="row">
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('amount',__('Contract Amount'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amount', $event->total + $bill->deposits,array('class'=>'form-control','placeholder'=>__('Enter Amount'),'required'=>'required','readonly'))); ?>

            </div>
        </div>
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('date',__('Contract Date'),['class'=>'form-label'])); ?>

                <input type="date" name="date" id="date" class="form-control" value="<?php echo e($event->start_date ?? date('Y-m-d')); ?>">
            </div>
        </div>
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('deposits',__('Deposits on Account'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('deposits', $bill->deposits + $total,array('class'=>'form-control','placeholder'=>__('Enter Deposits'),'readonly'))); ?>

            </div>
        </div>
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('latefee',__('Late Fee'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('latefee', $latefee, array('class'=>'form-control','placeholder'=>__('Enter Late Fee')))); ?>

            </div>
        </div>
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('adjustments',__('Adjustments'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('adjustments',$adjustments,array('class'=>'form-control','placeholder'=>__('Enter Adjustments')))); ?>

            </div>
</div>
        <!-- <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('other',__('Other Charges'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('other',null ,array('class'=>'form-control','placeholder'=>__('Enter Other Charges(If Any)')))); ?>

            </div>
        </div> -->
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('amountpaid',__('Total Paid'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amountpaid',null,array('class'=>'form-control','placeholder'=>__('Enter Amount Paid'),'readonly'))); ?>

            </div>
        </div>
 
    <div class="col-6">
        <div class="form-group">
            <?php echo e(Form::label('amountpaid',__('Total Paid'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('amountpaid',null,array('class'=>'form-control','placeholder'=>__('Enter Amount Paid'),'readonly'))); ?>

        </div>
    </div>
    <!-- <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('amountpaid',__('Paid Amount'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amountpaid',$total,array('class'=>'form-control','placeholder'=>__('Enter Amount Paid'),'readonly'))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('amounttobepaid',__('Amount to be paid'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amounttobepaid',null,array('class'=>'form-control','placeholder'=>__('Enter Adjustments'),'readonly'))); ?>

            </div>
        </div> -->
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('balance',__('Balance Due'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('balance',null,array('class'=>'form-control','placeholder'=>__('Enter Balance Due'),'readonly'))); ?>

            </div>
        </div>
        <div class="col-6 nee.d_full">
            <div class="form-group">
                <?php echo e(Form::label('amountcollect',__('Collect Amount'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amountcollect',null,array('class'=>'form-control','required'))); ?>

            </div>
        </div> 
        <div class="col-6 need_full">
            <div class="form-group">
                <?php echo e(Form::label('mode',__('Mode of Payment'),['class'=>'form-label'])); ?>

                <select name="mode" id="mode" class='form-select' required>
                    <option value="">Please select</option>
                    <option value="online"
                        <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'online') ?'selected' :'' : ''?>>
                        Online</option>
                    <option value="credit"
                        <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'credit') ?'selected' :'' : ''?>>
                        Credit</option>
                    <option value="cash"
                        <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cash') ?'selected' :'': '' ?>>
                        Cash</option>
                    <option value="cheque"
                        <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cheque') ?'selected' :'' : ''?>>
                        Cheque</option>
                </select>
                <!-- <div class="mt-4"> -->
                    <span class="msg" style="color:#5e7ebd !important"></span>
                <!-- </div> -->
            </div>
        </div>
        <div class="col-12 ">
            <div class="form-group">
                <?php echo e(Form::label('reference',__('Payment Reference'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('reference',$payment->reference ?? '',array('class'=>'form-control','placeholder'=>__('Enter Reference Id ')))); ?>

            </div>
        </div>

        <!-- <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('adjustmentnotes',__('Adjustment Notes'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('adjustmentnotes',$payment->adjustmentnotes ?? '',array('class'=>'form-control','placeholder'=>__('Enter Adjustment Notes')))); ?>

            </div>
        </div> -->
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('notes',__('Notes'),['class'=>'form-label'])); ?>

                <textarea name="notes" id="notes" cols="30" rows="5" class='form-control'
                    placeholder='Enter Notes'></textarea>
            </div>
        </div>


   
    <div class="col-6">
        <div class="form-group">
            <?php echo e(Form::label('amountcollect',__('Collect Amount'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('amountcollect',null,array('class'=>'form-control','required'))); ?>

        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php echo e(Form::label('mode',__('Mode of Payment'),['class'=>'form-label'])); ?>

            <select name="mode" id="mode" class='form-select' required>
                <option value="">Please select</option>
                <option value="online"
                    <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'online') ?'selected' :'' : ''?>>
                    Online</option>
                <option value="credit"
                    <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'credit') ?'selected' :'' : ''?>>
                    Credit</option>
                <option value="cash"
                    <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cash') ?'selected' :'': '' ?>>
                    Cash</option>
                <option value="cheque"
                    <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cheque') ?'selected' :'' : ''?>>
                    Cheque</option>
            </select>
            <!-- <div class="mt-4"> -->
            <span class="msg" style="color:#5e7ebd !important"></span>
            <!-- </div> -->
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?php echo e(Form::label('reference',__('Payment Reference'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('reference',$payment->reference ?? '',array('class'=>'form-control','placeholder'=>__('Enter Reference Id ')))); ?>

        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?php echo e(Form::label('notes',__('Notes'),['class'=>'form-label'])); ?>

            <textarea name="notes" id="notes" cols="30" rows="5" class='form-control'
                placeholder='Enter Notes'></textarea>
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
    <?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary '))); ?>

</div>
<?php else: ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                Contract must be approved by customer/admin before any further payment .
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- <?php if($event->status == 3): ?>
    <?php if(isset($paymentinfo)): ?>
        <?php if($paymentinfo->amounttobepaid == $total): ?>
        <div class="row">
            <div class="col-md-12">
                <dt class="col-md-6"><span class="h6  mb-0"><?php echo e(__('Bill Amount')); ?></span></dt>
                <dd class="col-md-6">
                    <span>$<?php echo e(isset($paymentinfo->amount) ? $paymentinfo->amount : $event->total); ?></span>
                </dd>
                <dt class="col-md-6"><span class="h6 text-md mb-0"><?php echo e(__('Status')); ?></span></dt>
                <dd class="col-md-6"><span class="text-md">
                        <span class="badge bg-success p-2 px-3 rounded">Payment Completed</span>

                </dd>
                <?php if(isset($info) && !empty($info)): ?>
                <table class="table">
                    <thead>
                        <th>Date</th>
                        <th>Mode Of Payment</th>
                        <th>Late Fee</th>
                        <th>Adjustments</th>
                        <th>Amount Paid</th>
                    </thead>
                    <tbody>

                        <?php $__currentLoopData = $info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(\Auth::user()->dateFormat($paymentinfo->created_at)); ?></td>
                            <td><?php echo e($paymentinfo->modeofpayment); ?></td>
                            <td><?php echo e($paymentinfo->latefee); ?></td>
                            <td><?php echo e($paymentinfo->adjustments); ?></td>
                            <td><?php echo e($total); ?></td>
                        <tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <?php echo e(Form::open(array('route' => ['billing.paymentinfoupdate', urlencode(encrypt($event->id))],'method'=>'post','enctype'=>'multipart/form-data'))); ?>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('amount',__('Amount'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('amount', $event->total + $bill->deposits,array('class'=>'form-control','placeholder'=>__('Enter Amount'),'required'=>'required','readonly'))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('date',__('Date'),['class'=>'form-label'])); ?>

                    <input type="date" name="date" id="date" class="form-control" value="<?php echo e($payment->date ?? date('Y-m-d')); ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('deposits',__('Deposits on file'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('deposits',$bill->deposits,array('class'=>'form-control','placeholder'=>__('Enter Deposits')))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('latefee',__('Late Fee'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('latefee', $payment->latefee ?? 0 , array('class'=>'form-control','placeholder'=>__('Enter Late Fee')))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('adjustments',__('Adjustments'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('adjustments',$payment->adjustments ?? 0 ,array('class'=>'form-control','placeholder'=>__('Enter Adjustments')))); ?>

                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('amountpaid',__('Paid Amount'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('amountpaid',$total,array('class'=>'form-control','placeholder'=>__('Enter Amount Paid'),'readonly'))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('amounttobepaid',__('Amount to be paid'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('amounttobepaid',null,array('class'=>'form-control','placeholder'=>__('Enter Adjustments'),'readonly'))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('balance',__('Balance Due'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::number('balance',null,array('class'=>'form-control','placeholder'=>__('Enter Balance Due'),'readonly'))); ?>

                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('mode',__('Mode of Payment'),['class'=>'form-label'])); ?>

                    <select name="mode" id="mode" class='form-select'>
                        <option value="online"
                            <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'online') ?'selected' :'' : ''?>>
                            Online</option>
                        <option value="credit"
                            <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'credit') ?'selected' :'' : ''?>>
                            Credit</option>
                        <option value="cash"
                            <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cash') ?'selected' :'': '' ?>>
                            Cash</option>
                        <option value="cheque"
                            <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cheque') ?'selected' :'' : ''?>>
                            Cheque</option>
                    </select>
                    <div class="mt-4">
                        <span class="msg text-primary"></span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('reference',__('Payment Reference'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::text('reference',$payment->reference ?? '',array('class'=>'form-control','placeholder'=>__('Enter Reference Id ')))); ?>

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?php echo e(Form::label('adjustmentnotes',__('Adjustment Notes'),['class'=>'form-label'])); ?>

                    <?php echo e(Form::text('adjustmentnotes',$payment->adjustmentnotes ?? '',array('class'=>'form-control','placeholder'=>__('Enter Adjustment Notes')))); ?>

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <?php echo e(Form::label('notes',__('Notes'),['class'=>'form-label'])); ?>

                    <textarea name="notes" id="notes" cols="30" rows="5" class='form-control'
                        placeholder='Enter Notes'></textarea>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
            <?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary '))); ?>

        </div>
        <?php echo e(Form::close()); ?>

        <?php endif; ?>
    <?php else: ?>
    <?php echo e(Form::open(array('route' => ['billing.paymentinfoupdate', urlencode(encrypt($event->id))],'method'=>'post','enctype'=>'multipart/form-data'))); ?>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('amount',__('Amount'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amount', $event->total + $bill->deposits,array('class'=>'form-control','placeholder'=>__('Enter Amount'),'required'=>'required','readonly'))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('date',__('Date'),['class'=>'form-label'])); ?>

                <input type="date" name="date" id="date" class="form-control" value="<?php echo e($payment->date ?? date('Y-m-d')); ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('deposits',__('Deposits on file'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('deposits',$bill->deposits,array('class'=>'form-control','placeholder'=>__('Enter Deposits')))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('latefee',__('Late Fee'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('latefee', $payment->latefee ?? 0 , array('class'=>'form-control','placeholder'=>__('Enter Late Fee')))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('adjustments',__('Adjustments'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('adjustments',$payment->adjustments ?? 0 ,array('class'=>'form-control','placeholder'=>__('Enter Adjustments')))); ?>

            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('amountpaid',__('Paid Amount'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amountpaid',$total,array('class'=>'form-control','placeholder'=>__('Enter Amount Paid'),'readonly'))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('amounttobepaid',__('Amount to be paid'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('amounttobepaid',null,array('class'=>'form-control','placeholder'=>__('Enter Adjustments'),'readonly'))); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('balance',__('Balance Due'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('balance',null,array('class'=>'form-control','placeholder'=>__('Enter Balance Due'),'readonly'))); ?>

            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('mode',__('Mode of Payment'),['class'=>'form-label'])); ?>

                <select name="mode" id="mode" class='form-select' required>
                    <option value="">Please select</option>
                    <option value="online"
                        <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'online') ?'selected' :'' : ''?>>
                        Online</option>
                    <option value="credit"
                        <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'credit') ?'selected' :'' : ''?>>
                        Credit</option>
                    <option value="cash"
                        <?php echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cash') ?'selected' :'': '' ?>>
                        Cash</option>
                    <option value="cheque"
                        <?php  echo isset($payment->modeofpayment) ?($payment->modeofpayment == 'cheque') ?'selected' :'' : ''?>>
                        Cheque</option>
                </select>
                <div class="mt-4">
                    <span class="msg text-primary"></span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('reference',__('Payment Reference'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('reference',$payment->reference ?? '',array('class'=>'form-control','placeholder'=>__('Enter Reference Id ')))); ?>

            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('adjustmentnotes',__('Adjustment Notes'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('adjustmentnotes',$payment->adjustmentnotes ?? '',array('class'=>'form-control','placeholder'=>__('Enter Adjustment Notes')))); ?>

            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('notes',__('Notes'),['class'=>'form-label'])); ?>

                <textarea name="notes" id="notes" cols="30" rows="5" class='form-control'
                    placeholder='Enter Notes'></textarea>
            </div>
        </div>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
        <?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary '))); ?>

    </div>
    <?php endif; ?>
<?php else: ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                Contract must be approved by customer/admin before any further payment .
            </div>
        </div>
    </div>
</div>
<?php endif; ?> -->
<script>
$('#mode').change(function() {
    var selected = $(this).val();
    if (selected == 'credit') {
        $('#reference').removeAttr('required');
    } else {
        setTimeout(function() {
            $('#reference').attr('required', 'required');
        }, 100);
    }
});
</script>


<script>
jQuery(function() {
    var amount = parseFloat($("input[name='amount']").val()) || 0;
    var deposits = parseFloat($("input[name='deposits']").val()) || 0;
    var latefee = parseFloat($("input[name='latefee']").val()) || 0;
    var adjustments = parseFloat($("input[name='adjustments']").val()) || 0;
    var other = parseFloat($("input[name='other']").val()) || 0;
    var amountpaid = deposits;
    var balance = amount  - amountpaid;
    $("input[name='balance']").val(balance);
    $("input[name='amountpaid']").val(amountpaid);
    $("input[name='amountcollect']").attr('max', balance);
    $("input[name='amount'],input[name='deposits'], input[name='latefee'], input[name='adjustments'], input[name='amountpaid'],input[name='other']")
        .keyup(function() {
            $("input[name='amountpaid']").empty();
            $("input[name='balance']").empty();
            var amount = parseFloat($("input[name='amount']").val()) || 0;
            var deposits = parseFloat($("input[name='deposits']").val()) || 0;
            var latefee = parseFloat($("input[name='latefee']").val()) || 0;
            var adjustments = parseFloat($("input[name='adjustments']").val()) || 0;
            var other = parseFloat($("input[name='other']").val()) || 0;

            // var amountpaid = parseFloat($("input[name='amountpaid']").val()) || 0;
            var amountpaid = deposits;
            $("input[name='amountpaid']").val(amountpaid);
            // var amounttobepaid = amount - deposits + latefee - adjustments;
            var balance = amount + other + latefee - adjustments - amountpaid;

            // Assuming you want to store the balance in an input field with name 'balance'
            $("input[name='balance']").val(balance);
            // $("input[name='amounttobepaid']").val(amounttobepaid);

            console.log('total', balance);
        });
    $('select[name = "mode"]').change(function() {
        $('.msg').html('');
        $('input[name="reference"]').removeAttr('required');
        var value = $(this).val();
        if (value == 'credit') {
            $('.msg').html('Pay Amount after form submission')
        } else {
            $('input[name="reference"]').attr('required');
        }
    })
});
</script><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/billing/pay-info.blade.php ENDPATH**/ ?>