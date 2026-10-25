import"./bootstrap-CAiCLEjY.js";const i=()=>{document.getElementById("table-aspirasi-body"),axios.get("/api/admin/aspirasi").then(e=>{const a=e.data;container.innerHTML="",a.forEach(t=>{const s=t.nama_mahasiswa.split(" ").map(n=>n[0]).join("").toUpperCase().substring(0,2);container.innerHTML+=`
                    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                ${s}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">${t.nama_mahasiswa}</h3>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 uppercase tracking-wider">
                                    ${t.kategori}
                                </span>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4 italic">
                            "${t.pesan}"
                        </p>
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center text-[10px] text-slate-400 font-medium">
                            <span>ID: ${t.id}</span>
                            <span>21 Des 2025</span>
                        </div>
                    </div>
                `})}).catch(e=>{e.response&&e.response.status===403&&(alert(e.response.data.message),window.location.href="/login"),console.error("Error fetching data:",e)})};document.addEventListener("DOMContentLoaded",i);
