<?php $this->load->view('{lower_name}/head') ?>

<table border="0" cellpadding="0" cellspacing="1" style="width:100%">
 <tr>
	<th>Edit</th>
	<th>Delete</th>
	<?php foreach($fields as $field): ?>
	<th><?php echo $field; ?></th>
	<?php endforeach; ?>
</tr>

<?php foreach($query->result() as $row): ?>
 <tr>
	<td>&nbsp;<?php echo anchor(array($base_uri, 'edit', $row->$primary), 'Edit'); ?>&nbsp;</td>
 	<td><?php echo anchor(array($base_uri, 'delete', $row->$primary), 'Delete'); ?></td>
 	<?php foreach($fields as $field): ?>	
	<td><?php echo form_prep($row->$field);?></td>
	<?php endforeach; ?>
 </tr>
<?php endforeach; ?>
</table>

<?php echo $paginate; ?>

<?php $this->load->view('{lower_name}/foot') ?>
 
/* End of file view.php */
/* Location: /application/views/{lower_name}/view.php */