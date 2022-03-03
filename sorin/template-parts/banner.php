<?php
if(is_home()):?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                       <h1 class="title"><?php echo get_the_title( get_option('page_for_posts', true) );?></h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif(is_archive()): ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                        <h1 class="title">
                            <?php post_type_archive_title();?>
                        </h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif (is_single()): ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                        <?php the_title( ' <h1 class="title">', '</h1>' ); ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif(is_page()): ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                        <?php the_title( ' <h1 class="title">', '</h1>' ); ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
		                <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif(is_404()): ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                         <h1 class="title">404</h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif(is_search()): ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                        <?php the_title( ' <h1 class="title">', '</h1>' ); ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-inner">
                        <?php the_title( ' <h1 class="title">', '</h1>' ); ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="breadcumbs">
			            <?php echo srBreadcumbs($delimiter);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
