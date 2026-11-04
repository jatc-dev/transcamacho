CREATE TABLE "User" (
  "id" TEXT NOT NULL, "name" TEXT NOT NULL, "email" TEXT NOT NULL, "emailVerified" BOOLEAN NOT NULL DEFAULT false,
  "image" TEXT, "role" TEXT NOT NULL DEFAULT 'operator', "active" BOOLEAN NOT NULL DEFAULT true,
  "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "User_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "User_email_key" ON "User"("email");
CREATE TABLE "Session" (
  "id" TEXT NOT NULL, "expiresAt" TIMESTAMP(3) NOT NULL, "token" TEXT NOT NULL, "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP(3) NOT NULL, "ipAddress" TEXT, "userAgent" TEXT, "userId" TEXT NOT NULL,
  CONSTRAINT "Session_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Session_token_key" ON "Session"("token");
CREATE TABLE "Account" (
  "id" TEXT NOT NULL, "accountId" TEXT NOT NULL, "providerId" TEXT NOT NULL, "userId" TEXT NOT NULL,
  "accessToken" TEXT, "refreshToken" TEXT, "idToken" TEXT, "accessTokenExpiresAt" TIMESTAMP(3), "refreshTokenExpiresAt" TIMESTAMP(3),
  "scope" TEXT, "password" TEXT, "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "Account_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Account_providerId_accountId_key" ON "Account"("providerId","accountId");
CREATE TABLE "Verification" (
  "id" TEXT NOT NULL, "identifier" TEXT NOT NULL, "value" TEXT NOT NULL, "expiresAt" TIMESTAMP(3) NOT NULL,
  "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "Verification_pkey" PRIMARY KEY ("id")
);
CREATE INDEX "Verification_identifier_idx" ON "Verification"("identifier");
CREATE TABLE "Driver" (
  "id" TEXT NOT NULL, "fullName" TEXT NOT NULL, "documentNumber" TEXT NOT NULL, "licenseNumber" TEXT NOT NULL,
  "licenseExpiresAt" DATE NOT NULL, "phone" TEXT, "email" TEXT, "active" BOOLEAN NOT NULL DEFAULT true,
  "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "Driver_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Driver_documentNumber_key" ON "Driver"("documentNumber");
CREATE INDEX "Driver_fullName_idx" ON "Driver"("fullName");
CREATE TABLE "Vehicle" (
  "id" TEXT NOT NULL, "plate" TEXT NOT NULL, "modelYear" INTEGER NOT NULL, "brand" TEXT NOT NULL, "vehicleClass" TEXT NOT NULL,
  "internalNumber" TEXT NOT NULL, "transportCard" TEXT NOT NULL, "transportCardExpiry" DATE, "carrierName" TEXT, "carrierTaxId" TEXT,
  "active" BOOLEAN NOT NULL DEFAULT true, "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "Vehicle_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Vehicle_plate_key" ON "Vehicle"("plate");
CREATE TABLE "Contract" (
  "id" TEXT NOT NULL, "contractNumber" TEXT NOT NULL, "clientName" TEXT NOT NULL, "clientTaxId" TEXT NOT NULL, "purpose" TEXT NOT NULL,
  "contractYear" INTEGER NOT NULL, "representative" TEXT NOT NULL, "representativeId" TEXT NOT NULL, "representativePhone" TEXT NOT NULL,
  "representativeAddress" TEXT NOT NULL, "active" BOOLEAN NOT NULL DEFAULT true, "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP(3) NOT NULL, CONSTRAINT "Contract_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Contract_contractNumber_key" ON "Contract"("contractNumber");
CREATE TABLE "Fuec" (
  "id" TEXT NOT NULL, "number" INTEGER NOT NULL, "contractId" TEXT NOT NULL, "vehicleId" TEXT NOT NULL, "primaryDriverId" TEXT NOT NULL,
  "clientName" TEXT NOT NULL, "clientTaxId" TEXT NOT NULL, "contractPurpose" TEXT NOT NULL, "origin" TEXT NOT NULL, "destination" TEXT NOT NULL,
  "carrierName" TEXT NOT NULL, "startsAt" DATE NOT NULL, "endsAt" DATE NOT NULL, "additionalDrivers" JSONB, "representative" TEXT NOT NULL,
  "representativeId" TEXT NOT NULL, "representativePhone" TEXT NOT NULL, "representativeAddress" TEXT NOT NULL, "issuedYear" INTEGER NOT NULL,
  "createdById" TEXT NOT NULL, "status" TEXT NOT NULL DEFAULT 'draft', "pdfObjectKey" TEXT, "qrToken" TEXT NOT NULL,
  "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP, "updatedAt" TIMESTAMP(3) NOT NULL,
  CONSTRAINT "Fuec_pkey" PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX "Fuec_number_key" ON "Fuec"("number");
CREATE UNIQUE INDEX "Fuec_qrToken_key" ON "Fuec"("qrToken");
CREATE INDEX "Fuec_startsAt_endsAt_idx" ON "Fuec"("startsAt","endsAt");
CREATE INDEX "Fuec_status_number_idx" ON "Fuec"("status","number");
CREATE TABLE "AuditEvent" (
  "id" TEXT NOT NULL, "userId" TEXT, "action" TEXT NOT NULL, "entityType" TEXT NOT NULL, "entityId" TEXT,
  "metadata" JSONB, "ipAddress" TEXT, "createdAt" TIMESTAMP(3) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT "AuditEvent_pkey" PRIMARY KEY ("id")
);
CREATE INDEX "AuditEvent_entityType_entityId_idx" ON "AuditEvent"("entityType","entityId");
CREATE INDEX "AuditEvent_createdAt_idx" ON "AuditEvent"("createdAt");
ALTER TABLE "Session" ADD CONSTRAINT "Session_userId_fkey" FOREIGN KEY ("userId") REFERENCES "User"("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "Account" ADD CONSTRAINT "Account_userId_fkey" FOREIGN KEY ("userId") REFERENCES "User"("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "Fuec" ADD CONSTRAINT "Fuec_contractId_fkey" FOREIGN KEY ("contractId") REFERENCES "Contract"("id") ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE "Fuec" ADD CONSTRAINT "Fuec_vehicleId_fkey" FOREIGN KEY ("vehicleId") REFERENCES "Vehicle"("id") ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE "Fuec" ADD CONSTRAINT "Fuec_primaryDriverId_fkey" FOREIGN KEY ("primaryDriverId") REFERENCES "Driver"("id") ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE "AuditEvent" ADD CONSTRAINT "AuditEvent_userId_fkey" FOREIGN KEY ("userId") REFERENCES "User"("id") ON DELETE SET NULL ON UPDATE CASCADE;
