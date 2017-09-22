<span id="part">
<?php $states = get_states_list($country_id);?>
<select name="RegionID" id="RegionID"  class="txtstyle">
<option value="">Select State</option>
<?php foreach($states as $state) { ?>	
    <option value="<?php echo $state['RegionID'];?>"><?php echo utf8_encode($state['Region']);?></option>                                              
  <?php } ?>
</select>
</span>