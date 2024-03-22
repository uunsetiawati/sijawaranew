<div class="content" style="flex: 1 0 auto">
    <div class="container px-4 px-md-0 py-4 pb-6 pt-3">
        <h5 class="py-2 fw-semibold">Shopping Cart</h5>
        <div class="row">
            <div class="col-12 col-lg-9 pe-3">
                <table class="table table-borderless" style="color: #8A8A8E">
                    <thead>
                        <tr class="fw-normal">
                            <td scope="col" width="2%"></td>
                            <td scope="col" width="43%">Product</td>
                            <td scope="col" width="18%">Price</td>
                            <td scope="col" width="18%"></td>
                            <td scope="col" width="18%">Action</td>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider text-black" style="border-color:#C8C8C8; border-top-width: 2px !important">
                        <?php if (!empty($checkout)) { ?>
                            <?php foreach ($checkout as $item) : ?>
                                <tr class="align-items-center" id="items-<?= $item['ID_ORDER'] ?>">
                                    <td scope="row" class="text-center align-items-center">
                                        <input class="form-check-input" type="checkbox" name="cb_order" value="<?= $item['ID_ORDER'] ?>" data-price="<?= $item['PRICE_ORDER'] ?>" style="cursor: pointer;" onchange="CountTotalPrice(this)">
                                    </td>
                                    <td class="flex-row d-flex align-items-center">
                                        <img src="<?= (!empty($item['IMAGE_ACTIVITY'])) ? $item['IMAGE_ACTIVITY'] : $item['IMAGE_EBOOK']; ?>" class="d-block img-fluid rounded-2 w-25">
                                        <span class="ms-2"><?= (!empty($item['TITLE_ACTIVITY'])) ? $item['TITLE_ACTIVITY'] : $item['JUDUL']; ?></span>
                                    </td>
                                    <td class="align-items-center">
                                        <?= ($item['PRICE_ORDER'] <> 0) ? "Rp " . number_format($item['PRICE_ORDER'], 2, ',', '.') : 'Free' ?>
                                    </td>
                                    <td></td>
                                    <td class="align-items-center">
                                        <button type="button" class="btn btn-outline-danger" data-id="<?= $item['ID_ORDER'] ?>" onclick="DeleteProduct(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                                                </path>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-center">
                                        <img src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1253.jpg" height="370">
                                    </div>
                                    <p class="text-center">No Product</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-lg-3 ">
                <div class="input-group shadow rounded-4 border px-2 py-1">
                    <input class="form-control shadow-none border-0 rounded-pill search" type="text" placeholder="Search promo" id="search-form">
                    <div class="vr" style="margin-top:8px;margin-bottom:8px;margin-right:2px"></div>
                    <span class="input-group-append">
                        <button class="btn btn-outline-black bg-white rounded-pill" style type="button" id="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </span>
                </div>
                <div class="dropdown mt-4">
                    <div id="search-result" class="col-md-12 dropdown-menu rounded-2 dropdown-primary px-2">
                    </div>
                </div>
                <div class="rounded-2 pt-3 pb-2 mt-2" style="background-color:#E9E9E9;">
                    <h5 class="fw-semibold px-4">Order Summary</h5>
                    <hr class="my-0 border border-1" style="border-color:#C8C8C8 !important">
                    <div class="col d-flex flex-row mx-4 my-2 justify-content-between h-auto">
                        <p class="fs-5 m-0">
                            Total
                        </p>
                        <p class="fs-5 m-0" id="total_pay">
                            Rp 0,00
                        </p>
                    </div>

                </div>
                <form id="FormBuyNow" method="POST" action="<?= base_url('purchase') ?>">
                    <div id="data-input"></div>
                    <div class="col-12 mt-3 btn btn-primary fw-semibold fs-4 text-white" style="background-color:#5580E9 !important" onclick="BuyNow()">Buy Now</div>

                    <?php if (!empty($checking_trans)) { ?>
                        <div class="col-12 mt-3 text-center">
                            <a class=" text-muted fw-semibold fs-5" style="text-decoration:none !important" href="<?= base_url('purchase') ?>">
                                Check Last Transaction
                            </a>
                        </div>
                    <?php } ?>
                    <?php ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->session->flashdata('msg'); ?>
<script>
    var data = []
    var PreviousPayment = 0
    var TotalPayment = 0
    var idPromoCode = 0

    window.onload = function() {
        $('input[type="checkbox"]').prop('checked', false)
    }

    function CountTotalPrice(e) {
        let id = $(e).val()
        let value = $(e).data("price")
        if ($(e).is(':checked')) {
            TotalPayment += $(e).data("price")
            data.push({
                id: id,
                value: value
            })
        } else {
            for (let index = 0; index < data.length; index++) {
                if (data[index].id == id) {
                    locationIndex = index
                    data = data.filter(function(e) {
                        return e.id !== id;
                    });
                }
            }
            TotalPayment -= $(e).data("price")
        }
        PreviousPayment = TotalPayment
        $('#total_pay').html('Rp ' + format(TotalPayment) + ',00')
    }

    $('#search-btn').click(function() {
        $('#search-result').html("");
        getData($('#search-form').val())
    })

    $('#search-form').focusout(function() {
        $('#search-result').hide()
    })

    $('#search-form').click(function(e) {
        $('#search-result').html("");
        getData($(this).val())
    });

    $('#search-form').keyup(function(e) {
        if (e.which == 13) {
            $('#search-result').html("");
            getData($(this).val())
        }
    });

    function getData(key) {
        <?php if (!empty($list_promo)) { ?>
            <?php foreach ($list_promo as $item) { ?>
                $('#search-result').append(
                    `<button class="d-flex flex-row align-items-center dropdown-item py-3" 
                        data-promo-name="<?= $item['PROMO_NAME'] ?>" 
                        data-value="<?= $item['AMMOUNT'] ?>"
                        data-id-code="<?= $item['ID_PROMO'] ?>" onclick="Disc(this)">
                        <div class="col-md-9">
                            <?= $item['PROMO_NAME'] ?>
                        </div>
                        <div class="col-md-2 vr" style="margin-top:8px;margin-bottom:8px;"></div>
                        <div class="col-md-1 border-0 rounded-pill" style="margin-left:10px;">
                            <?= $item['AMMOUNT'] ?> %
                        </div>
                    </button>`
                )
            <?php } ?>
        <?php } else { ?>
            $('#search-result').append(`<a class='dropdown-item'>No promo found</a>`)
        <?php } ?>

        if ($('#search-result').html() != "") {
            $('#search-result').show();
        }
    }

    function Disc(e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        idPromoCode = $(e).data('id-code')
        if (TotalPayment != 0) {
            if (TotalPayment < PreviousPayment) {
                TotalPayment = PreviousPayment
            }
            
            $("#search-form").focusout();
            $('#search-form').val($(e).data('promo-name') + " " + $(e).data('value') + " %")
            TotalPayment = TotalPayment - (TotalPayment * ($(e).data('value') / 100));
            $('#total_pay').html('<s>Rp ' + format(PreviousPayment) + ',00</s> <br> Rp ' + format(TotalPayment) + ',00')
        } else {
            Toast.fire({
                icon: 'error',
                title: `You Cann't Use Coupon, if total is 0`
            })
        }
    }

    function BuyNow() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (!empty($checking_trans)) { ?>
            Toast.fire({
                icon: 'error',
                title: 'Complete your transaction first!'
            })
        <?php } else { ?>
            if (data != "") {
                for (let index = 0; index < data.length; index++) {
                    $('#data-input').append('<input type="hidden" name="id_order_purchase[' + index + ']" value="' + data[index].id + '" />')
                    $('#data-input').append('<input type="hidden" name="id_promo_code" value="' + idPromoCode + '" />')
                }
                $("#FormBuyNow").submit();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: '<?= (empty($checkout) != "") ? 'No product in cart!' : 'Please choose product first!' ?>'
                })
            }
        <?php } ?>
    }

    var format = function(num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ".") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(".");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

    function DeleteProduct(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let timerInterval
                Swal.fire({
                    title: 'Delete On Proccess !',
                    html: 'it will be over in a few seconds.',
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: "<?= base_url('delete/order?id_order=') ?>" + $(e).data("id"),
                            type: "GET",
                            success: function(data) {
                                $('#items-' + $(e).data("id")).remove()
                                location.reload()
                            }
                        });
                    }
                })
            }
        })
    }
</script>