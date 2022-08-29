$(document).ready(function () {

    $('.add-product-btn').on('click', function (e) {
        e.preventDefault();
        $(this).addClass('disabled')
        let [name, price, id, stock] = [$(this).data('name'), $(this).data('price'), $(this).data('id'), $(this).data('stock')]
        let orderItem = `<tr>
                <td>${name}</td>
                <td><input type="number" step="1" min="1" max="${stock}"  value=1 name="products[${id}]" class="form-control input-sm order-item" data-price="${price}"></td>
                <td>${price}</td>
                <td class="total-price">${price}</td>
                <td><button class="btn btn-sm btn-danger remove-product-btn" data-id="product-${id}"><i class="fa fa-trash"></i></button></td>
            </tr>`;
        $('.order-list').append(orderItem)
        calculateTotal();
    })

    $('body').on('click', '.remove-product-btn', function (e) {
        e.preventDefault()
        let id = $(this).data('id')
        $('#' + id).removeClass('disabled')
        $(this).closest('tr').remove()
        calculateTotal();
    })

    $('body').on('change', '.order-item', function () {

        let quantity = +$(this).val(); //2
        let unitPrice = +$(this).data('price'); //150
        $(this).closest('tr').find('.total-price').html((quantity * unitPrice).toFixed(2));
        calculateTotal();
    });//end of product quantity change


})

function calculateTotal() {
    let totalOrderCost = 0;

    $('.total-price').each(function () {
        totalOrderCost += +$(this).html()
    });
    //console.log(totalOrderCost)
    $('#total_order_cost').html(totalOrderCost.toFixed(2));
    if (totalOrderCost > 0) {
        $('#add-order-form-btn').removeClass('disabled')
    } else {
        $('#add-order-form-btn').addClass('disabled')
    }

}//end of calculate total


