<div class="col-md-6 col-xs-12 col-sm-12">


    <div class="col-md-6">
        <?php
        $lead_count = count($data_lead);
        $icon_total_lead = 'fa fa-book';
        $caption_total_lead = $this->MainModels->getCaption(count($data_lead), 'Lead');
        $card_total_lead = $this->ComponentModels->statiscticsCard($lead_count, $caption_total_lead, $icon_total_lead, 'big');
        echo $card_total_lead;
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $sales_officer_count = count($data_sales_officer);
        $icon_sales_officer = 'fa fa-user';
        $caption_sales_officer = $this->MainModels->getCaption(count($data_sales_officer), 'Sales Officer');
        $card_sales_officer = $this->ComponentModels->statiscticsCardReverse($sales_officer_count, $caption_sales_officer, $icon_sales_officer, 'big');
        echo $card_sales_officer;
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $new_lead_count = count($data_new_leads);
        $icon_new_leads = 'fa fa-newspaper-o';
        $caption_new_leads = $this->MainModels->getCaption(count($data_new_leads), 'New Lead');
        $card_new_leads = $this->ComponentModels->statiscticsCardReverse($new_lead_count, $caption_new_leads, $icon_new_leads, 'big');
        echo $card_new_leads;
        ?>
    </div>
    <div class="col-md-6">
        <?php
        $progress_lead_count = count($data_onprogress);
        $icon_progress_leads = 'fa fa-history';
        $caption_progress_leads = $this->MainModels->getCaption(count($data_onprogress), 'On progres');
        $card_progress_leads = $this->ComponentModels->statiscticsCardReverse($progress_lead_count, $caption_progress_leads, $icon_progress_leads, 'big');
        echo $card_progress_leads;
        ?>
    </div>


</div>