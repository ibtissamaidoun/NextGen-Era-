import { test, expect } from '@playwright/test';

test('test_offre', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('admin1@gmail.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('123456');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.goto('http://localhost:8080/dashboard-admin');
  await page.goto('http://localhost:8080/dashboard-admin/Offres');
});
test('test_offreajouter', async ({ page }) => {
  await page.getByRole('button', { name: 'Ajouter l\'offre' }).click();
  await page.getByPlaceholder('Titre').click();
  await page.getByPlaceholder('Titre').fill('aid');
  await page.getByPlaceholder('Déscription').click();
  await page.getByPlaceholder('Déscription').fill('dhddn');
  await page.getByPlaceholder('Date de début de l\'inscription').click();
  await page.getByPlaceholder('Date de début de l\'inscription').fill('2024-07-08');
  await page.getByPlaceholder('Date de la fin de l\'').click();
  await page.getByPlaceholder('Date de la fin de l\'').fill('2024-09-02');
  await page.getByPlaceholder('Remise (%)').click();
  await page.getByPlaceholder('Remise (%)').fill('30');
  await page.getByText('Sélectionnez une option de').click();
  await page.getByText('trimestriel').click();
  await page.getByText('Choisissez des activités').click();
  await page.getByText('Exploration en laboratoire de').click();
  page.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page.getByRole('button', { name: 'Ajouter', exact: true }).click();
});
