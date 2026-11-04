import type { Metadata } from "next";
import "./globals.css";
export const metadata: Metadata = { title: "Transcamacho | Gestión de transporte especial", description: "Plataforma de gestión de contratos, conductores, vehículos y FUEC." };
export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) { return <html lang="es"><body>{children}</body></html>; }
