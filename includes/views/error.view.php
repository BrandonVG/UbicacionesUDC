  </div>
<style>
  .img-error {
    min-width: 200px;
    min-height: 100px;
  }
  .message-size {
    font-size: 1.5rem !important;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
      <p class="message-size"><?php echo $message !== false ? $message : ''; ?></p>
      <img src="<?php echo $url; ?>public/images/errors/<?php echo $code; ?>.png" class="img-fluid img-error" alt="Error">
    </div>
  </div>
</div>
<script>
  $('#sidebar').hide();
</script>