<?= $ScriptMidtrans ?>
<div class="content test" style="flex: 1 0 auto">
    <div class="container px-4 px-md-0 py-4 pb-6 pt-3">
        <h5 class="py-2 fw-semibold">Purchase</h5>
        <div class="row">
            <div>
                <span class="fs-6" style="color: #505050">
                    Your order
                </span>
                <form id="form-purchase" method="POST" action="<?= base_url('check_payment_status') ?>" class="border border-1 mt-2 px-4 py-2">
                    <table class="table table-borderless" style="color: #8A8A8E">
                        <thead>
                            <tr class="fw-normal">
                                <td scope="col" width="43%">Product</td>
                                <td scope="col" width="18%"></td>
                                <td scope="col" width="18%"></td>
                                <td scope="col" width="18%">Price</td>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                            <?php
                            $TotalBayar = 0;
                            foreach ($order[0] as $item) :
                                $TotalBayar += $item['PRICE_ORDER'];
                            ?>
                                <tr class="">
                                    <td class="flex-row d-flex align-items-center">
                                        <img src="<?= (!empty($item['IMAGE_ACTIVITY'])) ? $item['IMAGE_ACTIVITY'] : $item['IMAGE_EBOOK']; ?>" class="d-block img-fluid rounded-2 w-25">
                                        <span class="ms-2"><?= (!empty($item['TITLE_ACTIVITY'])) ? $item['TITLE_ACTIVITY'] : $item['JUDUL']; ?></span>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_activity[]" value="<?= $item['ID_PRODUCT'] ?>">
                                        <input type="hidden" name="price[]" value="<?= $item['PRICE_ORDER'] ?>">
                                    </td>
                                    <td><input type="hidden" name="tot_bayar" value="<?= $TotalBayar ?>"></td>
                                    <td><?= "Rp " . number_format($item['PRICE_ORDER'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex flex-column-reverse">
                        <table class="table table-borderless">
                            <thead>
                                <?php if (!empty($promo['AMMOUNT'])) { ?>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left" scope="col" width="18%">Sub Total</td>
                                        <td scope="col" width="18%">
                                            <s><?= "Rp " . number_format($TotalBayar, 2, ',', '.') ?></s>
                                        </td>
                                    </tr>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left" scope="col" width="18%"></td>
                                        <td scope="col" width="18%">
                                            <?php
                                            $NewTotBayar = $TotalBayar - ($TotalBayar * ($promo['AMMOUNT'] / 100));
                                            echo "Rp " . number_format($NewTotBayar, 2, ',', '.')
                                            ?>
                                        </td>
                                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $NewTotBayar ?>">
                                        <input type="hidden" name="id_promo_code" value="<?= $promo['ID_PROMO'] ?>">
                                    </tr>
                                <?php } else { ?>
                                    <tr class="fw-semibold">
                                        <td scope="col" width="61%"></td>
                                        <td class="text-left" scope="col" width="18%">Sub Total</td>
                                        <td scope="col" width="18%">
                                            <?= "Rp " . number_format($TotalBayar, 2, ',', '.') ?>
                                        </td>
                                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $TotalBayar ?>">
                                        <input type="hidden" name="id_promo_code" value="">
                                    </tr>
                                <?php } ?>
                            </thead>
                        </table>
                    </div>
                    <input type="hidden" name="id_trans" value="<?= $id_trans ?>">
                    <input type="hidden" name="id_pay_method" value="<?= !empty($checking_trans) ? $checking_trans[0]['ID_PAY_METHOD'] : '' ?>">
                    <?php foreach ($order[0] as $item) { ?>
                        <input type="hidden" name="id_order_whenPay[]" value="<?= $item['ID_ORDER'] ?>">
                    <?php } ?>
                </form>
                <div class="d-flex flex-column flex-md-row justify-content-end mt-4">
                    <form action="<?= (!empty($checking_trans)) ? base_url('delete/pay') : base_url('checkout') ?>" method="POST" id="form-cancel-trans">
                        <input type="hidden" name="id_trans" value="<?= (!empty($checking_trans)) ? $id_trans : "" ?>">
                        <?php foreach ($order[0] as $item) { ?>
                            <input type="hidden" name="id_order[]" value="<?= $item['ID_ORDER'] ?>">
                        <?php } ?>
                    </form>
                    <div class="col-12 col-md-3 btn btn-danger text-black fw-semibold fs-4 text-white" onclick="$('#form-cancel-trans').submit()">
                        Cancel Transaction
                    </div>
                    <div>
                        <div id="pay-btn-container"></div>
                    </div>
                    <div class="btn filled col-12 col-md-3 ms-md-3 mt-3 mt-md-0 d-flex align-items-center justify-content-center ms-0 btn text-black fw-semibold fs-4 text-white" style="background-color:#5580E9 !important" onclick="CobaPayment()">
                        Purchase Now
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    let timerInterval

    function CobaPayment() {
        if ($('#total_bayar').val() != 0) {
            $.ajax({
                url: "<?= base_url('guest_controller/CheckoutGuest/get_order_id') ?>",
                type: "POST",
                data: {
                    TotPrice: <?= (!empty($promo['AMMOUNT'])) ? ($TotalBayar - ($TotalBayar * ($promo['AMMOUNT'] / 100))) : $TotalBayar ?>,
                    id_order: $('input:hidden[name="id_order[]"]').map(function() {
                        return $(this).val()
                    }).get()
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.token) {
                        Swal.fire({
                            title: 'Open payment gateway ...',
                            html: 'it will be over in a few seconds.',
                            timer: 2000,
                            timerProgressBar: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((resp) => {
                            if (resp.dismiss === Swal.DismissReason.timer) {
                                snap.pay(response.token, {
                                    onSuccess: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onPending: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onError: function(result) {
                                        $('#form-purchase').submit();
                                    },
                                    onClose: function() {
                                        $('#form-purchase').submit();
                                    }
                                })

                            }
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Payment gateway get some trouble'
                        })
                    }
                }
            });
        } else {
            $('#form-purchase').submit()
        }
    }
</script>