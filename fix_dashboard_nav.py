# -*- coding: utf-8 -*-
from pathlib import Path
path = Path("resources/views/layouts/dashboard.blade.php")
text = path.read_text(encoding="utf-8")
lf = text.replace("\r\n", "\n")
start = lf.find("        if (Route::has('cursos.create-draft')) {")
if start == -1:
    raise SystemExit('draft block not found')
end = lf.find("\n\n", start)
if end == -1:
    raise SystemExit('end block not found')
block = lf[start:end]
replacement = "        if (Route::has('cursos.create')) {\n            $navLinks[] = [\n                'label' => 'Crear curso',\n                'icon' => '📦',\n                'url' => route('cursos.create'),\n                'active' => request()->routeIs('cursos.create'),\n            ];\n        }"
lf = lf[:start] + replacement + lf[end:]
old_nav = "            <div class=\"dashboard-nav\">\n                @foreach($navLinks as $link)\n                    @if(($link['method'] ?? 'get') === 'post')"
if old_nav not in lf:
    raise SystemExit('nav start snippet not found')
lf = lf.replace(lf[lf.index(old_nav):lf.index("            </div>", lf.index(old_nav))+len("            </div>")],
"            <div class=\"dashboard-nav\">\n                @foreach($navLinks as $link)\n                    <a href=\"{{ $link['url'] }}\" class=\"{{ $link['active'] ? 'active' : '' }}\">\n                        <span class=\"nav-icon\">{{ $link['icon'] }}</span>\n                        <span>{{ $link['label'] }}</span>\n                    </a>\n                @endforeach\n            </div>" ,1)
output = lf.replace("\n","\r\n")
path.write_text(output, encoding='utf-8')
