import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').press('CapsLock');
  await page.getByPlaceholder('Email').fill('A');
  await page.getByPlaceholder('Email').press('CapsLock');
  await page.getByPlaceholder('Email').fill('Ayoub@gmail.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('12345@');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.getByRole('button', { name: 'Ajouter un enfant' }).click();
  await page.getByPlaceholder('Nom', { exact: true }).click();
  await page.getByPlaceholder('Nom', { exact: true }).fill('hodaifa');
  await page.getByPlaceholder('PRÉNOM').click();
  await page.getByPlaceholder('PRÉNOM').fill('akdi');
  await page.getByPlaceholder('DATE DE NAISSANCE').click();
  await page.getByPlaceholder('DATE DE NAISSANCE').fill('2011-06-12');
  await page.getByPlaceholder('NIVEAU D\'ÉTUDE').click();
  await page.getByPlaceholder('NIVEAU D\'ÉTUDE').press('CapsLock');
  await page.getByPlaceholder('NIVEAU D\'ÉTUDE').fill('C');
  await page.getByPlaceholder('NIVEAU D\'ÉTUDE').press('CapsLock');
  await page.getByPlaceholder('NIVEAU D\'ÉTUDE').fill('College');
  await page.getByRole('button', { name: 'Ajouter', exact: true }).click();
  await page.getByRole('link', { name: ' Activités' }).click();
  await page.locator('div:nth-child(4) > .card > .card-body > .d-flex > a').click();
  await page.locator('li').filter({ hasText: 'Miran Akdi' }).click();
  await page.getByLabel('Miran Akdi').check();
  await page.getByLabel('Baran Akdi').check();
  await page.getByLabel('Dilan Akdi').check();
  await page.getByRole('button', { name: 'Ajouter au panier' }).click();
  const page1Promise = page.waitForEvent('popup');
  await page.locator('li:nth-child(2) > .px-0').click();
  const page1 = await page1Promise;
  page1.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page1.getByText('Demander').click();
  await page1.locator('a').filter({ hasText: 'PACK ENFANTSPack pour enfants' }).click();
  await page1.getByRole('link', { name: ' Demandes' }).click();
  page1.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page1.getByRole('row', { name: '3 2024-06-20 brouillon Voir' }).getByRole('link').nth(1).click();
  await page1.getByRole('link', { name: 'Offres' }).click();
  await page1.locator('div').filter({ hasText: /^Une offre spéciale pour nos clients fidèlesDétails$/ }).getByRole('link').click();
  await page1.getByLabel('Miran Akdi (College)').check();
  await page1.getByLabel('Baran Akdi (Primaire)').check();
  await page1.getByLabel('Dilan Akdi (Primaire)').check();
  page1.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page1.getByRole('button', { name: 'Soumettre' }).click();
});
