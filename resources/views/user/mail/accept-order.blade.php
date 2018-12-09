<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quang</title>
</head>

<body style="background-color: rgba(0,0,0,0.1);">
<div style="width: 65%; margin: auto; background-color: white;padding: 10px;">
    <h2>Xác nhận đơn hàng</h2>
    <a href="/">ASTEAM K60 - SaleSystem</a>
    <div style="padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
        <b>Đơn hàng của quý khách đã được chấp nhận, chúng tôi sẽ giao cho bạn trong thời gian sớm nhất!</b>
        <legend style="display: block;width: 100%;padding: 0;margin-bottom: 20px;font-size: 21px;line-height: inherit;color: #333;border: 0;border-bottom: 1px solid #e5e5e5;">Thông tin đơn hàng #{{$order->id}} <small style="color: #777;">{{$order->created_at}}</small></legend>
        <div style="@media screen and (min-width: 766px) {
                width: 50%;
                float: left;
        }">
            <p>Thông tin thanh toán</p>
            <ul>
                <li>Họ và tên khách hàng: {!! $user->name !!}</li>
                <li>Email: <a href="#">{!! $user->email !!}</a></li>
                <li>SDT: {!! $user->phone_number !!}</li>
            </ul>
        </div>
        <div style=" @media screen and (min-width: 766px) {
                width: 50%;
                float: left;
        }">
            <p>Địa chỉ giao hàng</p>
            <ul>
                <li>Họ và tên khách hàng: {!! $user->name !!}</li>
                <li>Địa chỉ: {!! $order->address !!}</li>
                <li>SDT: {!! $order->phone_number !!}</li>
            </ul>　
        </div>
        <p><b>Phí vận chuyển: </b>0đ (miễn phí)</p>
        <p><b>Phương thức thanh toán: </b>Thanh toán tiền mặt khi nhận hàng</p>
        <table style="clear: both;margin: auto;border: 1px solid black;line-height: 30px; width: 80%;">
            <legend>CHI TIẾT ĐƠN HÀNG</legend>
            <tr style="color: #fff;background-color: #337ab7;border-color: #2e6da4;">
                <th>SẢN PHẨM</th>
                <th>ĐƠN GIÁ</th>
                <th>SỐ LƯỢNG</th>
                {{--<th>GIẢM GIÁ</th>--}}
                <th>TỔNG</th>
            </tr>
            @foreach($orderDetail as $od)
                <tr>
                    <th>{{App\Model\OrderDetail::findOrFail($od->id)->product()->first()->name}}</th>
                    <th>{{App\Model\OrderDetail::findOrFail($od->id)->product()->first()->price}}$</th>
                    <th>{{$od->quantity}}</th>
                    <th class="product-price">{!! $od->total_price !!}$</th>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Tổng giá trị sản phẩm chưa giảm giá</td>
                <td class="product-price">{{$order->sub_total}}$</td>
            </tr>
            <tr>
                <td colspan="3">Giảm giá Phiếu Quà Tặng</td>
                <td>0.00$</td>
            </tr>
            <tr>
                <td colspan="3">Chi phí vận chuyển</td>
                <td>0.00$</td>
            </tr>
            <tr>
                <td colspan="3"><b>Tổng giá trị đơn hàng</b></td>
                <td><b class="product-price">{{$order->total}}$</b></td>
            </tr>
            <tfoot colspan="3">
            Ghi chú:  {{$order->note}}
            </tfoot>
        </table>

        <p>Trường hợp quý khách có những băn khoăn về đơn hàng, có thể xem thêm mục <a href="#">Các câu hỏi thường gặp.</a></p>
        <p>Bạn cần được hỗ trợ ngay? chỉ cần truy cập <a href="https://www.facebook.com/quang.peter.7" class="text-success">Minh Quang Facebook</a>, hoặc gọi số điện thoại <label class="text-success">01697655254</label> (8-21h cả ngày T7, CN). Đội ngũ BK Care luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
        <p><b>Một lần nữa ASTEAM K60 xin cảm ơn quý khách.</b></p>
    </div>
</div>
<script>
  $('.product-price').each((index, item) => {
    $(item)[0].innerText = formatMoney($(item)[0].innerText);
    $(item)[0].innerText += '$'
  })

  function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
    try {
      decimalCount = Math.abs(decimalCount);
      decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

      const negativeSign = amount < 0 ? "-" : "";

      let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
      let j = (i.length > 3) ? i.length % 3 : 0;

      return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
      console.log(e)
    }
  }
</script>
</body>
</html>