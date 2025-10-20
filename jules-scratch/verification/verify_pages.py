import os
from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()
    base_url = "http://localhost:8000"

    # --- Main Site Verification ---
    # Homepage
    page.goto(f"{base_url}/index.php")
    page.screenshot(path="jules-scratch/verification/homepage.png")

    # Product Page
    page.goto(f"{base_url}/product.php?slug=pomelo")
    page.screenshot(path="jules-scratch/verification/product_page.png")

    # Category Page
    page.goto(f"{base_url}/category.php?slug=fresh-fruit")
    page.screenshot(path="jules-scratch/verification/category_page.png")

    # --- Admin Panel Verification ---
    # Admin Login Page
    page.goto(f"{base_url}/admin/index.php")
    page.screenshot(path="jules-scratch/verification/admin_login.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
