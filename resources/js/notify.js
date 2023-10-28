
import Swal from 'sweetalert2'


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

let simpleAlert = (text='',type = 'success',title='Done !')=>{
    return Swal.fire({
        title: title,
        text: text,
        icon: type,
        showConfirmButton: false,
        timer: 2000,
    })
}

let okAlert = (type = 'success', title = '', text = '') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: type
    })

}

let topLeftAlert = (type = 'success', title = '') => {
    return Toast.fire({
        icon: type,
        title: title
    })
}

let confirmation  = (type = 'success', title = '', text = '') => {
    return Swal.fire({
        title:title,
        text: text,
        icon: type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })
}

let multiAlert = (type='success', title = '', fields = {}) => {
    let text = '';
    if(typeof fields == 'object'){
        let keys = Object.keys(fields);
        keys.forEach(element=>{
            text += `${fields[element]}\n`;
        })
    }
    // fields.forEach(element => {
    //     text += element+"\n";
    // });
    return Swal.fire({
        title:title,
        text: text,
        icon: type,
      })
}

export { okAlert , topLeftAlert,simpleAlert,confirmation,multiAlert};
