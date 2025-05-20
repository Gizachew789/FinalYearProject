// export function searchPatient(patientId, targetElementId) {
//     fetch(`staff/patients/search?patient_id=${encodeURIComponent(patientId)}`)
//         .then(response => response.json())
//         .then(data => {
//             const target = document.getElementById(targetElementId);
//             if (data.error) {
//                 target.innerHTML = `<p>${data.error}</p>`;
//             } else {
//                 target.innerHTML = `
//                     <h4>Patient Found:</h4>
//                     <p><strong>Name:</strong> ${data.name}</p>
//                     <p><strong>Patient ID:</strong> ${data.patient_id}</p>
//                 `;
//             }
//         })
//         .catch(error => {
//             const target = document.getElementById(targetElementId);
//             console.error('Search error:', error);
//             target.innerHTML = `<p>An error occurred. Try again.</p>`;
//         });
// }
