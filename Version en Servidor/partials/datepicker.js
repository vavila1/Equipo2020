 var element = document.querySelectorAll('.datepicker');
     M.Datepicker.init(element,{
      format: 'yyyy-mm-dd',
      showClearBtn: true,
      i18n:{
      	clear: 'Limpiar',
        cancel: 'Cancelar',
        done: 'Aceptar',
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
        weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
      }
     });