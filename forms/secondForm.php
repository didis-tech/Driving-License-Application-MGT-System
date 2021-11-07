<link rel="stylesheet" type="text/css" href="assets/css/croppie.css">
<script src="assets/js/croppie.js"></script>
<script src="assets/js/lga.min.js"></script>
<div class="col-lg-6">
  <form role="form" class="php-email-form" id="step2-form">
    <center>
      <div class="row">
        <div class="col-md-12 text-center">
          <div id="upload-demo" style="width:350px"></div>
        </div>
        <div class="col-md-12" style="padding-top:30px;">
          <strong>Select Image:</strong>
          <br />
          <input type="file" id="upload">
          <br />
        </div>
        <div class="col-md-12" class="user-profile-img">
          <div id="upload-demo-i"></div>
        </div>
      </div>
    </center>
    <div class="row">
      <div class="form-group">
        <input type="text" name="mother_maiden_name" class="form-control" id="mother_maiden_name" placeholder="Your Mother's maiden name" required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" required>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 select-section">
        <div class="row">
          <div class="col form-group">
            <select onchange="toggleLGA(this);" name="state" id="state" class="form-control" required>
              <option value="" selected="selected">- Select -</option>
              <option value="Abia">Abia</option>
              <option value="Adamawa">Adamawa</option>
              <option value="AkwaIbom">AkwaIbom</option>
              <option value="Anambra">Anambra</option>
              <option value="Bauchi">Bauchi</option>
              <option value="Bayelsa">Bayelsa</option>
              <option value="Benue">Benue</option>
              <option value="Borno">Borno</option>
              <option value="Cross River">Cross River</option>
              <option value="Delta">Delta</option>
              <option value="Ebonyi">Ebonyi</option>
              <option value="Edo">Edo</option>
              <option value="Ekiti">Ekiti</option>
              <option value="Enugu">Enugu</option>
              <option value="FCT">FCT</option>
              <option value="Gombe">Gombe</option>
              <option value="Imo">Imo</option>
              <option value="Jigawa">Jigawa</option>
              <option value="Kaduna">Kaduna</option>
              <option value="Kano">Kano</option>
              <option value="Katsina">Katsina</option>
              <option value="Kebbi">Kebbi</option>
              <option value="Kogi">Kogi</option>
              <option value="Kwara">Kwara</option>
              <option value="Lagos">Lagos</option>
              <option value="Nasarawa">Nasarawa</option>
              <option value="Niger">Niger</option>
              <option value="Ogun">Ogun</option>
              <option value="Ondo">Ondo</option>
              <option value="Osun">Osun</option>
              <option value="Oyo">Oyo</option>
              <option value="Plateau">Plateau</option>
              <option value="Rivers">Rivers</option>
              <option value="Sokoto">Sokoto</option>
              <option value="Taraba">Taraba</option>
              <option value="Yobe">Yobe</option>
              <option value="Zamfara">Zamafara</option>
            </select>
          </div>
          <div class="col form-group">
            <select name="lga" id="lga" class="form-control select-lga" required>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="address" id="address" placeholder="Your Address" required>

      </div>
      <div class="col form-group">
        <input type="text" class="form-control" name="bloodGroup" id="bloodGroup" placeholder="Your bloodGroup" required>

      </div>
      <div class="col form-group">
        <input type="number" class="form-control" name="height" id="height" placeholder="Your Height" required>

      </div>
      <div class="col form-group">
        <select id="color" class="form-control" name="color">
          <option selected disabled>Select your complexion</option>
          <option value="fair">fair</option>
          <option value="dark">dark</option>
        </select>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="male">
          <label class="form-check-label" for="exampleRadios1">
            male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="female">
          <label class="form-check-label" for="exampleRadios2">
            female
          </label>
        </div>
      </div>
      <div class="text-center"><button type="submit" class="upload-result">Apply</button><button type="reset" style="display:none" id="resetForm2">reset</button></div>
  </form>
  <script type="text/javascript">
    $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
        width: 200,
        height: 200,
        type: 'square'
      },
      boundary: {
        width: 300,
        height: 300
      }
    });


    $('#upload').on('change', function() {
      var reader = new FileReader();
      reader.onload = function(e) {
        $uploadCrop.croppie('bind', {
          url: e.target.result
        }).then(function() {
          console.log('jQuery bind complete');
        });

      }
      reader.readAsDataURL(this.files[0]);
    });


    $('#step2-form').submit(function(event) {
      var vidFileLength = $("#upload")[0].files.length;
      // var mother_maiden_name = $("#mother_maiden_name").val();
      // var phone = $("#phone").val();
      // var state = $("#state").val();
      // var lga = $("#lga").val();
      // var address = $("#address").val();
      // stop the form refreshing the page
      event.preventDefault();

      $('.form-group').removeClass('has-error'); // remove the error class
      $('.help-block').remove(); // remove the error text

      var formData = $(this).serializeArray();

      if (vidFileLength === 0) {
        alert("No file selected.");
      } else {
        $('#upload-result').addClass("disabled");
        $uploadCrop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(resp) {

          formData.push({
            name: "image",
            value: resp
          });

          $.ajax({
            url: "resources/step2.php",
            type: "POST",
            data: formData,
            success: function(data) {
              $("#resetForm2").click();
              $.alert({
                title: data.title,
                icon: `fa ${data.icon}`,
                type: data.type,
                content: data.message,
              });
              <?php if (!isset($_SESSION['userId'])) {
                echo "location.reload();";
              } ?>
              if (data.type == 'green') {
                $("#nav-tab a").removeClass('active');
                $("#nav-step3-tab").addClass('active');
                $("#nav-step3-tab").click();
              }
            }
          });
        });
      }
    });
  </script>
</div>
</div>