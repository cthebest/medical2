import moment from 'moment';

export function showAppointmentsDay(node, appointments) {

    appointments.forEach(element => {
        const parentPosition = node.getBoundingClientRect()
        const start_time = moment(element.start_time, 'h:mm A');
        const end_time = moment(element.end_time, 'h:mm A');
        // Obtenemos el nodo de tiempo inicial
        const start_time_node = node.querySelector('[data-time="' + start_time.format('h:mm A') + '"]').getBoundingClientRect();
        const end_time_node = node.querySelector('[data-time="' + end_time.format('h:mm A') + '"]').getBoundingClientRect();
        let appointmentNode = document.createElement("div");
        appointmentNode.style.position = "absolute";
        appointmentNode.style.top = start_time_node.top - parentPosition.top + 1 + 'px';
        appointmentNode.style.left = 70 + 'px';
        appointmentNode.style.width = parentPosition.width - 100 + 'px';
        appointmentNode.style.height = (end_time_node.top - start_time_node.top - 1) + 'px';
        appointmentNode.style.color = 'white';
        appointmentNode.style.padding = '5px'
        appointmentNode.style.backgroundColor = '#99cc33';
        appointmentNode.style.boxShadow = '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)'
        appointmentNode.style.fontSize = "0.875rem";
        appointmentNode.style.borderRadius = '9999px';
        appointmentNode.classList.add('appointment-schedule');
        appointmentNode.innerHTML = element.start_time + '-' + element.end_time + ' ' + element.patient.name;


        node.appendChild(appointmentNode);

    });

}