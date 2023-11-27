<li class="nav-item <?php
if ($this->uri->segment(1) == 'content') {
    echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-credit-card"></i>
        <span class="title">Content Management</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <?php
        $this->load->view('template/administrator/sub/status');
        ?>  
         <?php
        $this->load->view('template/administrator/sub/category');
        ?>
           
    </ul>
</li>