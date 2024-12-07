function toggleFields() {
    const certs = [
        'barangay_clearance',
        'business_permit_new',
        'business_permit_renew',
        'certificate_of_employability',
        'certificate_of_income',
        'cohabitation',
        'complaint_certificate',
        'death_certificate',
        'first_time_job_seeker',
        'indigency',
        'indigency_aics',
        'lot_ownership',
        'Oathtaking',
        'transfer_of_residency'
    ];

    certs.forEach(function(cert) {
        const formElement = document.getElementById(cert);
        if (formElement) {
            formElement.style.display = 'none'; // Hide each form
        }
    });

    // Get the selected certificate type
    const selectedCertificate = document.getElementById("certificateType").value;

    // Show the selected form
    if (selectedCertificate) {
        const selectedFormElement = document.getElementById(selectedCertificate);
        if (selectedFormElement) {
            selectedFormElement.style.display = 'block';
        }

        document.getElementById("myIframe").src = "certificates/" + selectedCertificate + ".html";
    } else {
        document.getElementById("myIframe").src = "";
    }
}
