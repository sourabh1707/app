<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

<script type='text/javascript'>
   $(document).ready(function(){
     $('.dateFilter').datepicker({
        dateFormat: "yy-mm-dd"
     });
   });
   </script>

  <div class="container-fluid">
    <div class="x_panel">
           

 <!--<form method='post' action=''>
     Start Date <input type='text' class='dateFilter' name='fromDate' value='<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>
 
     End Date <input type='text' class='dateFilter' name='endDate' value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

     <input type='submit' name='but_search' value='Search'>
   </form>
-->
<a class="pull-right btn btn-primary btn-xs" href="<?php echo site_url()?>export/generateXls"><i class="fa fa-file-excel-o"></i> Export Data</a>

            <div class="x_content">

    <table class="datatable table table-striped table-bordered">
      <thead>
        <tr>
          <th class="header">Sr. No.</th>
          <th class="header">Playlist Name</th>
          <th class="header">Playlist Status</th>
          <th class="header">Duration(Second)</th>
          <th class="header">Terminal/Group</th>
          <th class="header">Message</th>
          <th class="header">Schedule On</th>
          <th class="header">Schedule To</th>

        </tr>
      </thead>

    <!--  <tfoot>
        <tr>
          <th></th>
          <th>
            <input type="text" class="form-control input-sm filter-column">
          </th>
          <th>
            <input type="text" class="form-control input-sm filter-column" />
          </th>
         <th>
            <select class="form-control input-sm filter-column">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="B">C</option>
            </select>
          </th>
        </tr>
      </tfoot>
    -->
       <tbody>
            <?php
            $i = 1;

            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
                    //print_r($element);die();

                    $logs=unserialize($element['message']);
                          foreach ($logs as $key => $value) { 
                          

                          switch ($value) {
                          case '0' : $rvalue = 'Success';break;
                          case '1' : $rvalue = 'Fail';break;
                          default : $rvalue = $value;break;
                            }

                       }

                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $element['name']; ?></td> 
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <td><?php echo $element['duration']; ?></td>
                         <td><?php if($element['terminal_id']){ echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$element['terminal_id']))->name;
                         }else if($element['groupt_id']){ echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$element['groupt_id']))->name; } ?></td> 
                         <td><?php echo $rvalue;?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_on']; } ?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_to']; } ?></td>  

                    </tr>



                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">There is no field.</td>    
                </tr>
            <?php } ?>

        </tbody>
    </table>
  </div>
</div>
</div>
  
  <!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <!-- Responsive extension -->
  <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
  <!-- Buttons extension to export data -->
 <!-- <script src="//cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
-->


  <script>

var dataTable = $('.datatable').DataTable({
  buttons: [
    {
      extend: 'excel',

      text: 'Export to Excel',
      className: 'btn-sm btn-flat',
    },
  ],
  dom: "<'row'<'col-md-3'l><'col-md-6 text-center'B><'col-md-3'f>>" +
         "<'row'<'col-md-12'tr>>" +
         "<'row'<'col-md-5'i><'col-md-7'p>>",
  drawCallback: function(settings) {
    if (!$('.datatable').parent().hasClass('table-responsive')) {
      $('.datatable').wrap("<div class='table-responsive'></div>");
    }
  }
});

dataTable.columns().every(function() {
  var column = this;

  $('.filter-column', this.footer()).on('keyup change', function() {
    if (column.search() !== this.value) {
      column
        .search(this.value)
        .draw();
      this.focus();
    }
  });
});





/**
 * @author zhixin wen <wenzhixin2010@gmail.com>
 * extensions: https://github.com/kayalshri/tableExport.jquery.plugin
 */

(function ($) {
    'use strict';
    var sprintf = $.fn.bootstrapTable.utils.sprintf;

    var TYPE_NAME = {
        json: 'JSON',
        xml: 'XML',
        png: 'PNG',
        csv: 'CSV',
        txt: 'TXT',
        sql: 'SQL',
        doc: 'MS-Word',
        excel: 'MS-Excel',
        xlsx: 'MS-Excel (OpenXML)',
        powerpoint: 'MS-Powerpoint',
        pdf: 'PDF'
    };

    $.extend($.fn.bootstrapTable.defaults, {
        showExport: false,
        exportDataType: 'basic', // basic, all, selected
        // 'json', 'xml', 'png', 'csv', 'txt', 'sql', 'doc', 'excel', 'powerpoint', 'pdf'
        exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel'],
        exportOptions: {}
    });

    $.extend($.fn.bootstrapTable.defaults.icons, {
        export: 'glyphicon-export icon-share'
    });

    $.extend($.fn.bootstrapTable.locales, {
        formatExport: function () {
            return 'Export data';
        }
    });
    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales);

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initToolbar = BootstrapTable.prototype.initToolbar;

    BootstrapTable.prototype.initToolbar = function () {
        this.showToolbar = this.options.showExport;

        _initToolbar.apply(this, Array.prototype.slice.apply(arguments));

        if (this.options.showExport) {
            var that = this,
                $btnGroup = this.$toolbar.find('>.btn-group'),
                $export = $btnGroup.find('div.export');

            if (!$export.length) {
                $export = $([
                    '<div class="export btn-group">',
                        '<button class="btn' +
                            sprintf(' btn-%s', this.options.buttonsClass) +
                            sprintf(' btn-%s', this.options.iconSize) +
                            ' dropdown-toggle" aria-label="export type" ' +
                            'title="' + this.options.formatExport() + '" ' +
                            'data-toggle="dropdown" type="button">',
                            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.export),
                            '<span class="caret"></span>',
                        '</button>',
                        '<ul class="dropdown-menu" role="menu">',
                        '</ul>',
                    '</div>'].join('')).appendTo($btnGroup);

                var $menu = $export.find('.dropdown-menu'),
                    exportTypes = this.options.exportTypes;

                if (typeof this.options.exportTypes === 'string') {
                    var types = this.options.exportTypes.slice(1, -1).replace(/ /g, '').split(',');

                    exportTypes = [];
                    $.each(types, function (i, value) {
                        exportTypes.push(value.slice(1, -1));
                    });
                }
                $.each(exportTypes, function (i, type) {
                    if (TYPE_NAME.hasOwnProperty(type)) {
                        $menu.append(['<li role="menuitem" data-type="' + type + '">',
                                '<a href="javascript:void(0)">',
                                    TYPE_NAME[type],
                                '</a>',
                            '</li>'].join(''));
                    }
                });

                $menu.find('li').click(function () {
                    var type = $(this).data('type'),
                        doExport = function () {
                            that.$el.tableExport($.extend({}, that.options.exportOptions, {
                                type: type,
                                escape: false
                            }));
                        };

                    if (that.options.exportDataType === 'all' && that.options.pagination) {
                        that.$el.one(that.options.sidePagination === 'server' ? 'post-body.bs.table' : 'page-change.bs.table', function () {
                            doExport();
                            that.togglePagination();
                        });
                        that.togglePagination();
                    } else if (that.options.exportDataType === 'selected') {
                        var data = that.getData(),
                            selectedData = that.getAllSelections();

                        // Quick fix #2220
                        if (that.options.sidePagination === 'server') {
                            data = {total: that.options.totalRows};
                            data[that.options.dataField] = that.getData();

                            selectedData = {total: that.options.totalRows};
                            selectedData[that.options.dataField] = that.getAllSelections();
                        }

                        that.load(selectedData);
                        doExport();
                        that.load(data);
                    } else {
                        doExport();
                    }
                });
            }
        }
    };
})(jQuery);
  </script>
