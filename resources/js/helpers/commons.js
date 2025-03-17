// commons.js
function formatDate(dateString, kind = 'front') {
    if (!dateString) {
        return "Fecha no válida";
    }

    try {
        // Extraer año, mes y día de la cadena "YYYY-MM-DD"
        const [year, month, day] = dateString.split("-").map(Number);

        // Crear una fecha sin que JavaScript ajuste la zona horaria
        const date = new Date(year, month - 1, day); // Restamos 1 al mes porque en JS los meses van de 0-11

        if (kind === 'front') {
            const monthNames =  ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            return `${day} de ${monthNames[month - 1]} del ${year}`;
        } else if (kind === 'back') {
            return new Intl.DateTimeFormat('en-CA', { 
                year: 'numeric', 
                month: '2-digit', 
                day: '2-digit' 
            }).format(date);
        } else {
            throw new Error(`Tipo de formato "${kind}" no reconocido.`);
        }
    } catch (error) {
        console.error("Error al formatear la fecha:", error);
        return null;
    }
}

export default formatDate;
