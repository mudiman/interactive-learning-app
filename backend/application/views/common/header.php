<? $this -> load -> view('common/includeheader') ?>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<? echo base_url('home')?>">GoMadKids</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li <? if(isset($makecreatebookactive)) echo 'class="active"' ?>>
					<a href="<?php echo base_url('book/create')?>">Create Book</a>
				</li>
				<li <? if(isset($makemanagebookactive)) echo 'class="active"' ?>>
                    <a href="<?php echo base_url('book/managebook')?>">Manage Book</a>
                </li>
             <!--   <li >
				    <?php 
                        $options=array();
                        foreach ($this -> session ->userdata('books') as $book)
                            $options[]=array('link'=>'book/select'.$book->id,'name'=>$book->name);
                        echo generate_bootstrap_dropdowns("Select Book", $options);
				        //echo form_dropdown('name', $this -> session -> userdata('books'), $this -> session -> userdata('selectbook'),'id="bookselect" class="form-control" onChange="onBookSelect();"');
				    ?>
				</li> -->

			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Setting <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li>
							<a  href="<?php echo base_url('login/logout') ?>">Logout</a>
						</li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<?php if (isset($title)): ?>
<div class="page-header col-lg-10 col-sm-offset-1">
  <h2> <? echo  $title; ?></h2>
</div>
<?php endif; ?>