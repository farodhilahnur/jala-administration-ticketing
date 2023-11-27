<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Daily Notification</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">
        <style type="text/css">
            body, html, p{
                margin: 0;
            }
            .type{
                width: 100%;
                max-width: 480px;
                border-spacing:0; 
                border: 0 solid;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .chart-line{
                width: 80%;
                background: repeating-linear-gradient(
                    to left,
                    #ddd,
                    #ddd 1px,
                    #fff 1px,
                    #fff 25%
                    );
                height: 100%;
                padding: 10px 0;
            }
            .chart-caption{
                padding: 10px 10px 10px 0;
            }
            .chart{
                position: relative;
                height: 30px;
                background-color: rgb(126, 233, 116);
            }
            .chart:hover{
                background-color: rgb(85, 206, 54);
            }
            .chart span{
                float: right;
                margin-right: 5px;
                color: white;
                line-height: 30px;
            }
        </style>
    </head>
    <body style="margin:0; padding:0; background-color: white;">
        <h3>Dear <?php echo $client_name ; ?>,</h3>
        <p>Berikut kita informasikan report terkini dari Jala.AI</p>
        <table style="width:100%;">
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Lead Category</caption>
                        <?php
                        if (!empty($data_lead_category)) {
                            foreach ($data_lead_category as $dlc) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $dlc['category_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $dlc['percent'] . '%'; ?>;">
                                            <span><?php echo $dlc['total']; ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Lead Status</caption>
                        <?php
                        if (!empty($data_lead_status)) {
                            foreach ($data_lead_status as $dls) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $dls['status_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $dls['percent'] . '%'; ?>;">
                                            <span><?php echo $dls['total']; ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Channel Performance</caption>
                        <?php
                        if (!empty($channel_performance)) {
                            foreach ($channel_performance as $dcp) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $dcp['channel_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $dcp['percent'] . '%'; ?>;">
                                            <span><?php echo $dcp['total']; ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Campaign Performance</caption>
                        <?php
                        if (!empty($campaign_performance)) {
                            foreach ($campaign_performance as $dcc) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $dcc['campaign_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $dcc['percent'] . '%'; ?>;">
                                            <span><?php echo $dcc['total']; ?></span>
                                        </div>   
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Team Performance</caption>
                        <?php
                        if (!empty($team_performance)) {
                            foreach ($team_performance as $tp) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $tp['sales_team_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $tp['percent'] . '%'; ?>;">
                                            <span><?php echo $tp['total']; ?></span>
                                        </div>   
                                    </td>
                                </tr>   
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="type">
                        <caption style="color:black; margin-bottom: 10px; font-size: 20px; font-weight: 700;">Sales Performance</caption>
                        <?php
                        if (!empty($sales_performance)) {
                            foreach ($sales_performance as $tp) {
                                ?>
                                <tr class="chart-space">
                                    <td class="chart-caption"><?php echo $tp['sales_officer_name']; ?></td>
                                    <td class="chart-line">
                                        <div class="chart" style="width:<?php echo $tp['percent'] . '%'; ?>;">
                                            <span><?php echo $tp['total']; ?></span>
                                        </div>   
                                    </td>
                                </tr>   
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <p>Terima Kasih untuk perhatiannya. Untuk lebih detail, silahkan <a href="jala.ai/dashboard">login.</a>
        </p>
        <h4>Best Regards,</h4>
        <h4>Jala</h4>

    </body>
</html>