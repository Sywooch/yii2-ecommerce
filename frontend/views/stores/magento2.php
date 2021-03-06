<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use common\models\Country;

$this->title = 'Add Your Magento 2 Store';
$this->params['breadcrumbs'][] = 'Magento 2';
?>

<div class="page-head">
    <h2 class="page-head-title"><?= Html::encode($this->title) ?></h2>
    <ol class="breadcrumb page-head-nav">
        <?php
        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
        ?>
    </ol>
</div>
<div class="row wizard-row">
    <div class="col-md-12 fuelux">
        <div class="block-wizard panel panel-default">
            <div id="wizard-store-connection" class="wizard wizard-ux">
                <ul class="steps">
                    <li data-step="1" class="active">Authorize<span class="chevron"></span></li>
                    <li data-step="2">Connect<span class="chevron"></span></li>
                </ul>
                <div class="step-content">
                    <form id="magento-2-authorize-form" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" class="form-horizontal group-border-dashed">
                        <div class="form-group no-padding main-title">
                            <div class="col-sm-12">
                                <label class="control-label">Please provide your Magento Soap API Account details for Authorizing the Integration :</label>
                                <p> To integrate Magento 2x store with Elliot, you'll need to create Integration credentials in your Magento 2x store via <b> System > Integrations.</b> Please <a target="_blank" href="magento2x-configuration">Follow</a> this link.</p>
                                <div role="alert" class="alert alert-primary alert-dismissible">
                                    <span class="icon mdi mdi-info-outline"></span>
                                    Also you need to install our Magento module to sync your product, customer, order. Click to
                                    <a style="color: #fff;" href="/module/Elliot_module_magento2.zip" download><b>Download</b></a> our module.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Magento Store Url</label>
                            <div id="magento_2_shop" class="col-sm-6">
                                <input type="text" id="shop_url" placeholder="Please Enter value" class="form-control">
                                <em class="notes">Please use full store url ex "http://magento.com"</em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Access Token</label>
                            <div id="magento_2_access_token" class="col-sm-6">
                                <input type="text" placeholder="Please Enter value" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Store Country *</label>
                            <div id="wizard_magento_2_country" class="col-sm-6">
                                <select class="form-control customer_validate" id="magento_2_country"  name="cu-Country" style="color:#989696;">
                                    <option  value="">Please Select Value</option>
                                    <?php $countries = Country::find()->orderBy(['name' => SORT_ASC])->all(); foreach($countries as $val) { ?>
                                        <option value="<?php echo $val->sortname; ?>"><?php echo $val->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input id="user_id" type="hidden" value="<?= Yii::$app->user->identity->id; ?>" />
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-default btn-space"><a href="/">Cancel</a></button>
                                <button data-wizard="#wizard-store-connection" class="btn btn-primary btn-space wizard-next-auth-store-magento_2">Authorize & Connect</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="magento_2_ajax_request" tabindex="-1" role="dialog" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close magento_2_modal_close"></span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="text-success"><span class="modal-main-icon mdi mdi-check"></span></div>
                    <h3 id="ajax_header_msg">Success!</h3>
                    <p id="magento_2_ajax_msg"></p>
                    <div class="xs-mt-50">
                        <button type="button" data-dismiss="modal" class="btn btn-space btn-default magento_2_modal_close">Close</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="mod-danger" tabindex="-1" role="dialog" class="modal fade in magento_2_ajax_request_error" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close magento_2_error_modal_close"></span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
                    <h3 id='ajax_header_error_msg'></h3>
                    <p id="magento_2_ajax_msg_eror"></p>
                    <div class="xs-mt-50">
                        <button type="button" data-dismiss="modal" class="btn btn-space btn-default magento_2_error_modal_close">Close</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
