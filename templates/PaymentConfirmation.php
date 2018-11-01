<?php
  get_header();
?>

 <div style="position: relative; float: left; width: 100%;height: auto; margin-top: 10px;margin-bottom: 10px;">
  <div style="margin: 0 auto;width: 61%; border: 1">
   <div id="form_div">
   <h3>Payment Confirmation</h3>
   <form method="POST"  id="payment" action="<?php echo get_site_url() . '/wp-json/roketin/v1/PaymentConfirmation'  ?>" enctype="multipart/form-data" >
     <div style="margin: 2px;">
      <table>
      <tr>
          <td>
              <label for="noresi" style="width: 20%">Order Number:</label>

          </td>
          <td>
            <input required type="number" min="0" id="order_number"  name="order_number" style="width: 100%;" id="noresi" /><br>
          </td>
        </tr>
        <tr>
          <td>
              <label for="noresi" style="width: 20%">Transaction Number:</label>
          </td>
          <td>
            <input required type="text" id="transaction_number"  name="transaction_number" style="width: 100%;" id="noresi" /><br>
          </td>
        </tr>
        <tr>
          <td>
              <label for="noresi" style="width: 20%">Account Name:</label>
          </td>
          <td>
            <input required type="text" id="account_name"  name="account_name" style="width: 100%;" id="noresi" /><br>
          </td>
        </tr>
        <tr>
          <td>
              <label for="noresi" style="width: 20%">Account Number:</label>
          </td>
          <td>
            <input required type="number"  min="0" id="account_number" name="account_number" style="width: 100%;" id="noresi" /><br>
          </td>
        </tr>
        <tr>
            <td>
                <label for="noresi" style="width: 20%">Paid Date:</label>
            </td>
            <td>
                <input required type="date" id="paid_date" min="<?php echo date('Y-m-d'); ?>"  name="paid_date" style="width: 100%;" id="noresi" /><br>
            </td>
        </tr>
        <tr>
            <td>
                <label for="noresi" style="width: 20%">Nominal:</label>
            </td>
            <td>
                <input required type="number" min="0" id="nominal"  name="nominal" style="width: 100%;" id="noresi" /><br>
            </td>
        </tr>
        <tr>
            <td>
                <label for="noresi" style="width: 20%">Bank:</label>
            </td>
            <td>
                <select required id="bank" name="bank" style="width: 100%;" id="noresi" >
                  <?php
                  global $wpdb;
                  $db_bank = $wpdb->prefix . "roketin_payment";
                  $banks = $wpdb->get_results("SELECT * FROM $db_bank");

                  foreach($banks as $bank){
                      echo "<option value='" . $bank->id_bank_wc . "'>BANK " . $bank->bank_name . "</option>";
                  }

                  ?>
                </select>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <label for="noresi" style="width: 20%">Attachment:</label>
            </td>
            <td>
              <input required type="file" id="attachment" name="attachment" style="width: 100%;" />
            </td>  
        </tr>
        <tr>
          <td>
          </td>
          <td>
          <button class="btn btn-primary" style="width: 100%;" id="cekbutton" >Submit</button>      

          </td>
        </tr>
      </table>
      </div>
   </form>
    </div>
    <div id="result_div" style="display: none;">
    </div>
  </div>
 </div>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>
  function submit(){
    var orderNumber = document.getElementById('order_number');
    var transactionNumber = document.getElementById('transaction_number');
    var accountName = document.getElementById('account_name');
    var account_number = document.getElementById('account_number');
    var paidDate = document.getElementById('paid_date');
    var nominal = document.getElementById('nominal');
    var bank = document.getElementById('bank');
    var attachment = document.getElementById('attachment');
    
    axios.post('<?php get_site_url() . '/wp-json/roketin/v1/PaymentConfirmation' ?>', {
        'order_number': orderNumber.value,
        'transaction_number': transactionNumber.value,
        'account_name': accountName.value,
        'account_number': account_number.value,
        'paid_date': paidDate.value,
        'nominal': nominal.value,
        'bank': bank.value,
        'attachment': attachment.value
    }).then(function (response) {
        console.log(response)
    })
  }
</script>

<?php
  get_footer();
?>
