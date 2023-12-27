new DataTable('#example', {
  stateSave: true,
  scrollX: true,
  
  language: {
    info: 'Sayfa _PAGE_ / _PAGES_ gösteriliyor',
    infoEmpty: 'Kayıt bulunamadı',
    infoFiltered: '(_MAX_ toplam kayıttan filtrelendi)',
    lengthMenu: 'Sayfa başına _MENU_ kayıt görüntüle',
    zeroRecords: 'Hiçbir şey bulunmadı',
    search: 'Arama:',
    paginate: {
      first: 'Baş',
      last: 'Son',
      next: 'Sonraki',
      previous: 'Önceki',
    },
  },
});

$(document).ready(function () {
  $('#example').dataTable();
});
