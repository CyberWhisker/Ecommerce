// custom.js
$(document).ready(function() {
    $('#generate-pdf').on('click', function() {
        generatePDF();
    });
});

function generatePDF() {
    var element = document.body; // Choose the element that you want to export to PDF
    
    html2pdf(element, {
        margin: 10,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { 
            unit: 'mm', 
            format: 'a3', 
            orientation: 'landscape',
            putOnlyUsedFonts: true,
            floatPrecision: 16
        },
        pagebreak: { before: '.page-break' }
    });
}
