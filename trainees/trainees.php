<?php
// Trainees listing UI (mock data only). Replace with DB later.
include '../includes/header.php';
?>
<style>
  /* Trainees Animations */
  @keyframes riseIn {
    0% { opacity: 0; transform: translateY(12px); }
    100% { opacity: 1; transform: translateY(0); }
  }
  .anim-rise { animation: riseIn 0.45s ease-out both; }
</style>
<div class="min-h-screen bg-gradient-to-b from-violet-50 via-neutral-bg to-neutral-bg">
    <div class="w-full mx-auto px-6 md:px-10 py-6">
      <div class="bg-white border border-gray-100 rounded-2xl shadow-soft p-5 anim-rise">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="text-xl font-bold text-gray-800">Trainees Directory</div>
            <div class="text-xs text-gray-500">Dashboard Palette</div>
          </div>
          <div class="relative flex flex-wrap gap-3 items-center">
            <input id="searchInput" class="w-full lg:w-[520px] px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/30" type="text" placeholder="Search name, course, school, status..." />
            <button id="toggleAdvanced" class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-semibold hover:bg-gray-50">Advanced</button>
            <button id="clearFilters" class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-semibold">Reset</button><div id="metaSuggestions" class="absolute left-0 top-[54px] w-full lg:w-[520px] bg-white border border-gray-200 rounded-xl shadow-soft p-3 hidden z-10"></div>
          </div>
        </div>
      </div>

      <div class="mt-4 flex flex-wrap items-center gap-3 anim-rise">
        <div class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Quick Filters</div>
        <div id="quickFilters" class="flex flex-wrap gap-2"></div>
        <div class="ml-auto flex items-center gap-2">
          <span class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Grid</span>
          <button id="gridCompact" class="px-3 py-1 rounded-lg border border-gray-200 text-xs font-semibold hover:bg-gray-50">Compact</button>
          <button id="gridComfort" class="px-3 py-1 rounded-lg border border-gray-200 text-xs font-semibold bg-primary text-white">Comfortable</button>
        </div>
      </div>

      <div class="mt-4 grid grid-cols-1 lg:grid-cols-[360px_1fr] gap-6">
        <aside class="bg-white border border-gray-100 rounded-2xl shadow-soft p-4 h-[calc(100vh-160px)] anim-rise">
          <h3 class="font-display text-lg font-semibold text-gray-800">Schools</h3>
          <div id="schoolsList" class="mt-3 h-[calc(100%-48px)] overflow-y-auto pr-2"></div>
        </aside>

        <main class="bg-white border border-gray-100 rounded-2xl shadow-soft p-4 h-[calc(100vh-160px)] anim-rise">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
              <h3 class="font-display text-lg font-semibold text-gray-800">Trainees</h3>
              <div id="selectionLabel" class="text-sm text-gray-500">Showing all trainees</div>
            </div>
            <div id="resultCount" class="text-xs font-semibold px-3 py-1 rounded-full bg-violet-50 border border-violet-100 text-primary">0 results</div>
          </div>

          <div class="mt-4 h-[calc(100%-180px)] overflow-y-auto pr-2">
            <div id="traineesGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4"><div class="text-sm text-gray-400">Loading trainees...</div></div>
          </div>
        
          <div id="advancedPanel" class="hidden mt-4 p-4 rounded-xl border border-dashed border-gray-200 bg-violet-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="text-xs text-gray-500">Status</label>
                <select id="statusFilter" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white">
                  <option value="">All</option>
                  <option value="Active">Active</option>
                  <option value="Completed">Completed</option>
                </select>
              </div>
              <div>
                <label class="text-xs text-gray-500">Gender</label>
                <select id="genderFilter" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white">
                  <option value="">All</option>
                  <option value="Female">Female</option>
                  <option value="Male">Male</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-3">
              <div>
                <label class="text-xs text-gray-500">Sort By</label>
                <select id="sortBy" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white">
                  <option value="name">Name</option>
                  <option value="course">Course</option>
                  <option value="school">School</option>
                </select>
              </div>
              <div>
                <label class="text-xs text-gray-500">Sort Direction</label>
                <select id="sortDir" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white">
                  <option value="asc">Ascending</option>
                  <option value="desc">Descending</option>
                </select>
              </div>
              <div>
                <label class="text-xs text-gray-500">Batch</label>
                <select id="batchFilter" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white">
                  <option value="">All</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                </select>
              </div>
              <div>
                <label class="text-xs text-gray-500">Keyword</label>
                <input id="keywordFilter" type="text" placeholder="e.g. achiever, honor" class="w-full mt-1 px-3 py-2 rounded-lg border border-gray-200 bg-white" />
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>

  <div id="profileModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-soft w-full max-w-2xl mx-4">
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <div class="font-display text-lg font-semibold text-gray-800">Trainee Profile</div>
        <button id="closeModal" class="text-gray-400 hover:text-gray-600">Close</button>
      </div>
      <div id="modalContent" class="p-6"></div>
    </div>
  </div>

  <script>
    const schools = [
      "Northbridge Technical Institute",
      "Harborview College",
      "Pinecrest Academy",
      "Westfield Polytechnic",
      "Lakeside Institute",
      "Summit State College",
      "Rivermark University",
      "Crescent Bay School",
      "Highland Career Center",
      "Metrovale Training School"
    ];

    const courses = [
      "Web Development",
      "Data Analytics",
      "Network Administration",
      "Graphic Design",
      "Cybersecurity",
      "Digital Marketing",
      "Mobile App Development",
      "Cloud Computing",
      "Business Administration",
      "AI Fundamentals"
    ];

    const schoolCourses = {
      "Northbridge Technical Institute": ["Web Development", "Data Analytics", "AI Fundamentals"],
      "Harborview College": ["Graphic Design", "Digital Marketing", "Business Administration"],
      "Pinecrest Academy": ["Network Administration", "Cybersecurity"],
      "Westfield Polytechnic": ["Mobile App Development", "Cloud Computing"],
      "Lakeside Institute": ["Web Development", "Graphic Design"],
      "Summit State College": ["Data Analytics", "Business Administration", "AI Fundamentals"],
      "Rivermark University": ["Cybersecurity", "Cloud Computing"],
      "Crescent Bay School": ["Digital Marketing", "Mobile App Development"],
      "Highland Career Center": ["Network Administration", "Web Development"],
      "Metrovale Training School": ["AI Fundamentals", "Cloud Computing", "Data Analytics"]
    };

    const firstNames = ["Ava", "Liam", "Noah", "Mia", "Ethan", "Sofia", "Lucas", "Zoe", "Maya", "Leo", "Ivy", "Nora", "Kai", "Ella", "Owen", "Aria", "Finn", "Jade", "Miles", "Luna"];
    const lastNames = ["Santos", "Garcia", "Reyes", "Navarro", "Cruz", "Flores", "Lim", "Tan", "Villanueva", "Mendoza", "Gonzales", "Delos Reyes", "Pineda", "Torres", "Castillo", "Ramos", "Hernandez", "Aguilar", "Rivera", "Valdez"];
    const streets = ["Rizal Ave", "Quezon Blvd", "Bonifacio St", "Magsaysay Rd", "Luna St", "Roxas Ave", "Del Pilar St", "Taft Ave", "Mabini St", "Osmena Blvd"];
    const schedules = ["Mon-Wed 9:00 AM", "Tue-Thu 1:00 PM", "Mon-Fri 8:00 AM", "Sat 9:00 AM", "Wed-Fri 2:00 PM"];

    function makeTrainees() {
      const list = [];
      let id = 1;
      courses.forEach((course, idx) => {
        for (let i = 0; i < 10; i++) {
          const fn = firstNames[(idx + i) % firstNames.length];
          const ln = lastNames[(idx * 3 + i) % lastNames.length];
          const school = schools[(idx + i) % schools.length];
          const status = ["Active", "Completed", "On Leave"][i % 3];
          const gender = i % 2 === 0 ? "Female" : "Male";
          const batch = ["2024", "2025", "2026"][idx % 3];
          const imgIndex = (idx * 7 + i) % 70 + 1;
          const address = `${Math.floor(10 + i * 3)} ${streets[(idx + i) % streets.length]}, City`;
          const phone = `09${(idx + 1)}${(i + 2)}-${(100 + i * 7)}-${(200 + idx * 5)}`;
          const schedule = schedules[(idx + i) % schedules.length];
          list.push({
            id: id++,
            name: `${fn} ${ln}`,
            course,
            school,
            status,
            gender,
            batch,
            email: `${fn.toLowerCase()}.${ln.toLowerCase().replace(/\s/g, "")}${idx}@academy.edu`,
            keyword: i % 2 === 0 ? "honor" : "achiever",
            photo: `https://i.pravatar.cc/150?img=${imgIndex}`,
            address,
            phone,
            schedule
          });
        }
      });
      return list;
    }

    const trainees = makeTrainees();

    const state = {
      selectedSchool: "",
      selectedCourse: "",
      search: "",
      status: "",
      gender: "",
      sortBy: "name",
      sortDir: "asc",
      batch: "",
      keyword: "",
      grid: "comfort"
    };

    const schoolsList = document.getElementById("schoolsList");
    const traineesGrid = document.getElementById("traineesGrid");
    const resultCount = document.getElementById("resultCount");
    const selectionLabel = document.getElementById("selectionLabel");
    const metaSuggestions = document.getElementById("metaSuggestions");
    const quickFilters = document.getElementById("quickFilters");
    const profileModal = document.getElementById("profileModal");
    const modalContent = document.getElementById("modalContent");

    function escapeHtml(str) {
      return str.replace(/[&<>\"']/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
    }

    function escapeRegExp(str) {
      return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function highlightText(str, query) {
      if (!query) return escapeHtml(str);
      const tokens = query.split(/\s+/).map((t) => t.trim()).filter(Boolean);
      if (!tokens.length) return escapeHtml(str);
      let out = escapeHtml(str);
      tokens
        .sort((a, b) => b.length - a.length)
        .forEach((tok) => {
          const safe = escapeRegExp(tok);
          out = out.replace(new RegExp(safe, 'ig'), (m) => `<mark class=\"bg-yellow-200/80 text-gray-900 px-1 rounded\">${m}</mark>`);
        });
      return out;
    }

    function statusBadge(status) {
      const map = {
        'Active': 'bg-green-100 text-green-700 border-green-200',
        'Completed': 'bg-blue-100 text-blue-700 border-blue-200',      };
      const cls = map[status] || 'bg-gray-100 text-gray-600 border-gray-200';
      return `<span class=\"px-2 py-0.5 rounded-full text-xs font-semibold border ${cls}\">${status}</span>`;
    }

    function renderSchools() {
      if (!schoolsList) return;
      schoolsList.innerHTML = "";
      schools.forEach((school, i) => {
        const item = document.createElement("div");
        item.classList.add("anim-rise");
        item.style.animationDelay = `${i * 20}ms`;
        item.className = `border border-gray-200 rounded-xl p-3 mb-3 bg-white ${state.selectedSchool === school ? 'ring-2 ring-primary/30' : ''}`;

        const header = document.createElement("div");
        header.className = "flex items-center justify-between cursor-pointer";
        header.innerHTML = `
          <div class=\"font-semibold text-sm\">${school}</div>
          <div class=\"text-xs text-gray-500\">${schoolCourses[school].length} courses</div>
        `;

        const courseWrap = document.createElement("div");
        courseWrap.className = "mt-2 space-y-2 hidden";

        schoolCourses[school].forEach((course) => {
          const btn = document.createElement("button");
          btn.className = `w-full text-left px-3 py-2 rounded-lg border border-gray-200 text-xs hover:bg-gray-50 ${state.selectedCourse === course ? 'ring-2 ring-primary/30' : ''}`;
          btn.textContent = course;
          btn.addEventListener("click", (e) => {
            e.stopPropagation();
            state.selectedSchool = school;
            state.selectedCourse = course;
            renderSchools();
            renderTrainees();
          });
          courseWrap.appendChild(btn);
        });

        header.addEventListener("click", () => {
          state.selectedSchool = school === state.selectedSchool ? "" : school;
          state.selectedCourse = "";
          renderSchools();
          renderTrainees();
        });

        item.appendChild(header);
        item.appendChild(courseWrap);
        schoolsList.appendChild(item);

        if (state.selectedSchool === school) {
          courseWrap.classList.remove("hidden");
        }
      });
    }

    function buildMetaSuggestions() {
      const tokens = new Set();
      trainees.forEach((t) => {
        [t.name, t.course, t.school, t.status, t.gender, t.batch, t.keyword, t.address, t.phone, t.schedule].forEach((val) => {
          val.split(" ").forEach((word) => tokens.add(word.toLowerCase()));
        });
      });
      return Array.from(tokens).sort();
    }

    const metaTokens = buildMetaSuggestions();

    function renderSuggestions(value) {
      if (!metaSuggestions) return;
      const v = value.trim().toLowerCase();
      if (!v) {
        metaSuggestions.classList.add("hidden");
        metaSuggestions.innerHTML = "";
        return;
      }
      const matches = metaTokens.filter((t) => t.includes(v)).slice(0, 10);
      if (!matches.length) {
        metaSuggestions.classList.add("hidden");
        metaSuggestions.innerHTML = "";
        return;
      }
      metaSuggestions.innerHTML = matches.map((m) => {
        const label = highlightText(m, v);
        return `<button class=\"px-3 py-2 rounded-lg border border-gray-200 text-xs hover:bg-gray-50 mr-2 mb-2\" data-val=\"${m}\">${label}</button>`;
      }).join("");
      metaSuggestions.classList.remove("hidden");
      metaSuggestions.querySelectorAll("button").forEach((chip) => {
        chip.addEventListener("click", () => {
          document.getElementById("searchInput").value = chip.dataset.val;
          state.search = chip.dataset.val;
          metaSuggestions.classList.add("hidden");
          renderTrainees();
        });
      });
    }

    function renderQuickFilters() {
      if (!quickFilters) return;
      const options = ["All", "Active", "Completed"];
      quickFilters.innerHTML = options.map((opt) => {
        const active = (opt === "All" && !state.status) || state.status === opt;
        return `<button class=\"px-3 py-1 rounded-full border border-gray-200 text-xs font-semibold ${active ? 'bg-primary text-white' : 'hover:bg-gray-50'}\" data-val=\"${opt}\">${opt}</button>`;
      }).join("");
      quickFilters.querySelectorAll("button").forEach((btn) => {
        btn.addEventListener("click", () => {
          const val = btn.dataset.val;
          state.status = val === "All" ? "" : val;
          document.getElementById("statusFilter").value = state.status;
          renderQuickFilters();
          renderTrainees();
        });
      });
    }

    function applyFilters(list) {
      return list
        .filter((t) => !state.selectedSchool || t.school === state.selectedSchool)
        .filter((t) => !state.selectedCourse || t.course === state.selectedCourse)
        .filter((t) => !state.status || t.status === state.status)
        .filter((t) => !state.gender || t.gender === state.gender)
        .filter((t) => !state.batch || t.batch === state.batch)
        .filter((t) => {
          const q = state.search.toLowerCase();
          if (!q) return true;
          const hay = `${t.name} ${t.course} ${t.school} ${t.status} ${t.gender} ${t.batch} ${t.keyword} ${t.address} ${t.phone} ${t.schedule}`.toLowerCase();
          return hay.includes(q);
        })
        .filter((t) => {
          const kw = state.keyword.toLowerCase();
          if (!kw) return true;
          return t.keyword.toLowerCase().includes(kw) || t.name.toLowerCase().includes(kw);
        })
        .sort((a, b) => {
          const dir = state.sortDir === "asc" ? 1 : -1;
          return String(a[state.sortBy]).localeCompare(String(b[state.sortBy])) * dir;
        });
    }

    function setGridClass() {
      traineesGrid.className = state.grid === "compact"
        ? "mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3"
        : "mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4";
    }

    function renderTrainees() {
      try {
      if (!traineesGrid) return;
      const filtered = applyFilters(trainees);
      const q = state.search.trim();
      const compact = state.grid === "compact";
      const cardPadding = compact ? "p-3" : "p-4";
      const avatarSize = compact ? "w-10 h-10" : "w-12 h-12";
      traineesGrid.innerHTML = "";
      filtered.forEach((t, i) => {
        const card = document.createElement("button");
        card.classList.add("anim-rise");
        card.style.animationDelay = `${i * 20}ms`;
        card.type = "button";
        card.className = `text-left border border-gray-200 rounded-2xl ${cardPadding} bg-white hover:shadow-soft transition-shadow focus:outline-none focus:ring-2 focus:ring-primary/30`;
        card.innerHTML = `
          <div class=\"flex items-center gap-3\">
            <div class=\"relative ${avatarSize} rounded-xl overflow-hidden bg-violet-100 text-primary flex items-center justify-center font-bold text-sm\">
              <img src=\"${t.photo}\" alt=\"${t.name}\" class=\"w-full h-full object-cover\" onerror=\"this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');\" />
              <span class=\"hidden\">${t.name.split(' ').map(p => p[0]).join('')}</span>
            </div>
            <div>
              <div class=\"font-semibold text-gray-800\">${highlightText(t.name, q)}</div>
              <div class=\"text-xs text-gray-500\">Batch ${t.batch} - ${t.gender}</div>
            </div>
          </div>
          <div class=\"mt-3 text-sm\">
            <div class=\"flex items-center justify-between\">
              <span class=\"text-gray-500\">Course</span>
              <span class=\"font-semibold text-right\">${highlightText(t.course, q)}</span>
            </div>
            <div class=\"flex items-center justify-between mt-1\">
              <span class=\"text-gray-500\">School</span>
              <span class=\"font-semibold text-right\">${highlightText(t.school, q)}</span>
            </div>
            <div class=\"flex items-center justify-between mt-1\">
              <span class=\"text-gray-500\">Status</span>
              ${statusBadge(t.status)}
            </div>
          </div>
          <div class=\"mt-3 text-xs text-gray-500 break-words\">${highlightText(t.email, q)}</div>
        `;
        card.addEventListener("click", () => openModal(t));
        traineesGrid.appendChild(card);
      });

      if (resultCount) { resultCount.textContent = `${filtered.length} results`; }
      if (!filtered.length) { traineesGrid.innerHTML = `<div class=\"text-sm text-gray-400\">No trainees found.</div>`; }
      } catch (err) {
        traineesGrid.innerHTML = `<div class=\"text-sm text-red-500\">Render error: ${err.message}</div>`;
      }
      const label = state.selectedCourse
        ? `${state.selectedSchool} - ${state.selectedCourse}`
        : state.selectedSchool
        ? state.selectedSchool
        : "Showing all trainees";
      if (selectionLabel) { selectionLabel.textContent = label; }
    }

    function skeleton() {
      return `
        <div class=\"animate-pulse space-y-4\">
          <div class=\"flex items-center gap-3\">
            <div class=\"w-16 h-16 rounded-2xl bg-gray-200\"></div>
            <div class=\"space-y-2 flex-1\">
              <div class=\"h-4 bg-gray-200 rounded w-1/2\"></div>
              <div class=\"h-3 bg-gray-200 rounded w-1/3\"></div>
            </div>
          </div>
          <div class=\"grid grid-cols-1 md:grid-cols-2 gap-3\">
            <div class=\"h-10 bg-gray-200 rounded\"></div>
            <div class=\"h-10 bg-gray-200 rounded\"></div>
            <div class=\"h-10 bg-gray-200 rounded\"></div>
            <div class=\"h-10 bg-gray-200 rounded\"></div>
          </div>
          <div class=\"h-4 bg-gray-200 rounded w-2/3\"></div>
        </div>
      `;
    }

    function openModal(t) {
      const q = state.search.trim();
      profileModal.classList.remove("hidden");
      profileModal.classList.add("flex");
      modalContent.innerHTML = skeleton();
      setTimeout(() => {
        modalContent.innerHTML = `
          <div class=\"flex items-center gap-4\">
            <div class=\"relative w-20 h-20 rounded-2xl overflow-hidden bg-violet-100 text-primary flex items-center justify-center font-bold text-lg\">
              <img src=\"${t.photo}\" alt=\"${t.name}\" class=\"w-full h-full object-cover\" onerror=\"this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');\" />
              <span class=\"hidden\">${t.name.split(' ').map(p => p[0]).join('')}</span>
            </div>
            <div>
              <div class=\"text-xl font-semibold text-gray-800\">${highlightText(t.name, q)}</div>
              <div class=\"text-sm text-gray-500\">${highlightText(t.course, q)} - ${highlightText(t.school, q)}</div>
              <div class=\"text-xs text-gray-400\">Batch ${t.batch} - ${t.gender}</div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
            <div class=\"p-3 rounded-xl border border-gray-200\">
              <div class=\"text-xs text-gray-500\">Status</div>
              ${statusBadge(t.status)}
            </div>
            <div class=\"p-3 rounded-xl border border-gray-200\">
              <div class=\"text-xs text-gray-500\">Email</div>
              <div class=\"font-semibold break-words\">${highlightText(t.email, q)}</div>
            </div>
            <div class=\"p-3 rounded-xl border border-gray-200\">
              <div class=\"text-xs text-gray-500\">Keyword</div>
              <div class=\"font-semibold\">${highlightText(t.keyword, q)}</div>
            </div>
            <div class=\"p-3 rounded-xl border border-gray-200\">
              <div class=\"text-xs text-gray-500\">Address</div>
              <div class=\"font-semibold\">${highlightText(t.address, q)}</div>
            </div>
            <div class=\"p-3 rounded-xl border border-gray-200\">
              <div class=\"text-xs text-gray-500\">Phone</div>
              <div class=\"font-semibold\">${highlightText(t.phone, q)}</div>
            </div>
            <div class=\"p-3 rounded-xl border border-gray-200 md:col-span-2\">
              <div class=\"text-xs text-gray-500\">Schedule</div>
              <div class=\"font-semibold\">${highlightText(t.schedule, q)}</div>
            </div>
          </div>
        `;
      }, 600);
    }

    document.getElementById("closeModal").addEventListener("click", () => {
      profileModal.classList.add("hidden");
      profileModal.classList.remove("flex");
    });

    profileModal.addEventListener("click", (e) => {
      if (e.target === profileModal) {
        profileModal.classList.add("hidden");
        profileModal.classList.remove("flex");
      }
    });

    document.getElementById("searchInput").addEventListener("input", (e) => {
      state.search = e.target.value;
      renderSuggestions(state.search);
      renderTrainees();
    });

    document.getElementById("toggleAdvanced").addEventListener("click", () => {
      const panel = document.getElementById("advancedPanel");
      panel.classList.toggle("hidden");
    });

    document.getElementById("clearFilters").addEventListener("click", () => {
      Object.assign(state, {
        selectedSchool: "",
        selectedCourse: "",
        search: "",
        status: "",
        gender: "",
        sortBy: "name",
        sortDir: "asc",
        batch: "",
        keyword: "",
        grid: "comfort"
      });
      document.getElementById("searchInput").value = "";
      document.getElementById("statusFilter").value = "";
      document.getElementById("genderFilter").value = "";
      document.getElementById("sortBy").value = "name";
      document.getElementById("sortDir").value = "asc";
      document.getElementById("batchFilter").value = "";
      document.getElementById("keywordFilter").value = "";
      document.getElementById("gridCompact").classList.remove("bg-primary", "text-white");
      document.getElementById("gridComfort").classList.add("bg-primary", "text-white");
      renderQuickFilters();
      setGridClass();
      renderSchools();
      renderTrainees();
    });

    document.getElementById("statusFilter").addEventListener("change", (e) => { state.status = e.target.value; renderQuickFilters(); renderTrainees(); });
    document.getElementById("genderFilter").addEventListener("change", (e) => { state.gender = e.target.value; renderTrainees(); });
    document.getElementById("sortBy").addEventListener("change", (e) => { state.sortBy = e.target.value; renderTrainees(); });
    document.getElementById("sortDir").addEventListener("change", (e) => { state.sortDir = e.target.value; renderTrainees(); });
    document.getElementById("batchFilter").addEventListener("change", (e) => { state.batch = e.target.value; renderTrainees(); });
    document.getElementById("keywordFilter").addEventListener("input", (e) => { state.keyword = e.target.value; renderTrainees(); });

    document.getElementById("gridCompact").addEventListener("click", () => {
      state.grid = "compact";
      document.getElementById("gridCompact").classList.add("bg-primary", "text-white");
      document.getElementById("gridComfort").classList.remove("bg-primary", "text-white");
      setGridClass();
    });

    document.getElementById("gridComfort").addEventListener("click", () => {
      state.grid = "comfort";
      document.getElementById("gridComfort").classList.add("bg-primary", "text-white");
      document.getElementById("gridCompact").classList.remove("bg-primary", "text-white");
      setGridClass();
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".relative")) {
        metaSuggestions.classList.add("hidden");
      }
    });

    renderQuickFilters();
    setGridClass();
    renderSchools();
    renderTrainees();
  </script>

<?php include '../includes/footer.php'; ?>
</body>
</html>












