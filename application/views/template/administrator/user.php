<li class="nav-item <?php
if ($this->uri->segment(1) == 'team') {
echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-user"></i>
        <span class="title">User Management</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <?php
        $this->load->view('template/administrator/sub/client');
        // $this->load->view('template/administrator/sub/sales_team');
        // $this->load->view('template/administrator/sub/sales_officer');    
        ?>   
    </ul>
</li>