// resources/js/admin-aspirasi.js

import './bootstrap'; // Memastikan axios terkonfigurasi

const fetchAspirasi = () => {
    const tableBody = document.getElementById('table-aspirasi-body');
    
    axios.get('/api/admin/aspirasi')
        .then(response => {
            const data = response.data;
            container.innerHTML = ''; // Hapus loading shimmer

            data.forEach(item => {
                // Ambil inisial nama (Contoh: Budi Santoso -> BS)
                const inisial = item.nama_mahasiswa.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);

                container.innerHTML += `
                    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                ${inisial}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">${item.nama_mahasiswa}</h3>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 uppercase tracking-wider">
                                    ${item.kategori}
                                </span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4 italic">
                            "${item.pesan}"
                        </p>
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center text-[10px] text-slate-400 font-medium">
                            <span>ID: ${item.id}</span>
                            <span>21 Des 2025</span>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => {
            if (error.response && error.response.status === 403) {
                alert(error.response.data.message);
                window.location.href = '/login';
            }
            console.error('Error fetching data:', error);
        });
};

// Panggil fungsi
document.addEventListener('DOMContentLoaded', fetchAspirasi);