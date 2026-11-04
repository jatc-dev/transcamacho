import { redirect } from "next/navigation";
import { headers } from "next/headers";
import { auth } from "@/lib/auth";
export default async function Panel(){const session=await auth.api.getSession({headers:await headers()});if(!session)redirect("/ingresar");return <main className="shell"><header className="topbar"><a className="brand" href="/">TRANSCAMACHO</a><form action="/api/auth/sign-out" method="post"><button className="login">Cerrar sesión</button></form></header><section className="hero"><span className="eyebrow">PANEL OPERATIVO</span><h1>Hola, <em>{session.user.name}</em></h1><p>Tu espacio de gestión está listo. Los módulos se habilitarán progresivamente durante la modernización.</p><a className="primary" href="/">Ir al inicio</a></section></main>}
