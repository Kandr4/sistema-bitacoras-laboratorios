# Sistema de Asistencia por Escaneo de Código QR

> ✅ **Aprobado por el usuario** con las modificaciones detalladas a continuación.

## Descripción

Cada laboratorio tendrá un código QR único. Al escanearlo desde una sesión activa de profesor, se registra automáticamente la asistencia. Si no hay sesión activa, se redirige a login.

---

## Proposed Changes

### Dependencia

```bash
composer require simplesoftwareio/simple-qrcode
```

### Corrección: Seeder

#### [MODIFY] [AdminUserSeeder.php](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/database/seeders/AdminUserSeeder.php)
- Corregir `'rol' => 'Tecnico'` → `'rol' => 'Técnico'` (con acento)

---

### Base de Datos

#### [NEW] `database/migrations/XXXX_add_qr_token_to_laboratorio_table.php`
- Agrega `qr_token` (`string`, `unique`, `nullable`) a tabla [laboratorio](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/app/Models/Falla.php#27-32)

#### [NEW] `database/migrations/XXXX_create_asistencias_table.php`

| Columna | Tipo | Restricciones |
|---------|------|---------------|
| `idasistencia` | `bigint` | PK |
| `idusuario` | `bigint` | FK → `users.id` |
| `idlaboratorio` | `bigint` | FK → `laboratorio.idlab` |
| `entrada` | `datetime` | NOT NULL |
| `salida` | `datetime` | nullable |
| `fecha` | [date](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/app/Policies/IncidenciaPolicy.php#20-26) | NOT NULL |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

> Sin restricción unique — un profesor puede registrar múltiples asistencias el mismo día en el mismo laboratorio.

---

### Modelos

#### [MODIFY] [Laboratorio.php](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/app/Models/Laboratorio.php)
- Agregar `'qr_token'` a `$fillable`

#### [NEW] `app/Models/Asistencia.php`
- `$table = 'asistencias'`, `$primaryKey = 'idasistencia'`
- Relaciones: [usuario()](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/app/Models/Incidencia.php#29-32) → User, [laboratorio()](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/app/Models/Falla.php#27-32) → Laboratorio

---

### Controlador

#### [NEW] `app/Http/Controllers/QrAsistenciaController.php`

| Método | Ruta | Rol | Descripción |
|--------|------|-----|-------------|
| `generarQr($idlab)` | POST `admin/laboratorios/{idlab}/qr` | Admin | Genera UUID token y muestra QR |
| `mostrarQr($idlab)` | GET `admin/laboratorios/{idlab}/qr` | Admin | Muestra QR existente |
| `registrar($token)` | GET `/asistencia/registrar/{token}` | Profesor | Registra asistencia y muestra confirmación |

> Historiales (admin y profesor) se implementarán en la siguiente iteración.

---

### Rutas

#### [MODIFY] [web.php](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/routes/web.php)

Agregar rutas para escaneo (auth) y generación de QR (admin).

---

### Vistas

#### [NEW] `resources/views/admin/laboratorios/qr.blade.php` — QR imprimible
#### [NEW] `resources/views/asistencia/confirmacion.blade.php` — Confirmación post-escaneo
#### [MODIFY] [resources/views/admin/laboratorios/index.blade.php](file:///c:/Users/rocky/Herd/sistema-bitacoras-laboratorios/resources/views/admin/laboratorios/index.blade.php) — Botón "Ver QR"

> Vistas de historial diferidas a siguiente iteración.

---

## Verification Plan

1. Login como Admin → generar QR para un laboratorio
2. Copiar URL del QR
3. Login como Profesor → abrir la URL → verificar registro exitoso
4. Abrir la URL de nuevo → verificar que crea un **nuevo** registro (sin bloqueo)
5. Verificar que un Técnico recibe error 403 al intentar escanear
