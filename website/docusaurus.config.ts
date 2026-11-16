import { themes as prismThemes } from "prism-react-renderer";
import type { Config } from "@docusaurus/types";
import type * as Preset from "@docusaurus/preset-classic";

const config: Config = {
  title: "Paystack PHP SDK",
  tagline: "Clean, developer-friendly Paystack API wrapper for PHP",

  future: {
    v4: true,
  },

  url: "https://matscode.github.io",
  baseUrl: "/paystack-php-sdk/",

  organizationName: "matscode",
  projectName: "paystack-php-sdk",
  trailingSlash: false,

  onBrokenLinks: "throw",

  headTags: [
    {
      tagName: "link",
      attributes: {
        rel: "preconnect",
        href: "https://fonts.googleapis.com",
      },
    },
    {
      tagName: "link",
      attributes: {
        rel: "preconnect",
        href: "https://fonts.gstatic.com",
        crossorigin: "anonymous",
      },
    },
    {
      tagName: "link",
      attributes: {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght,MONO@0,300..800,1;1,300..800,1&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap",
      },
    },
  ],

  i18n: {
    defaultLocale: "en",
    locales: ["en"],
  },

  presets: [
    [
      "classic",
      {
        docs: {
          sidebarPath: "./sidebars.ts",
          editUrl:
            "https://github.com/matscode/paystack-php-sdk/tree/main/website/",
        },
        blog: false, // Disabled since this is a focused SDK docs repository
        theme: {
          customCss: "./src/css/custom.css",
        },
      } satisfies Preset.Options,
    ],
  ],

  plugins: [
      "docusaurus-plugin-copy-page-button"
  ],

  themeConfig: {
    colorMode: {
      respectPrefersColorScheme: true,
    },
    navbar: {
      title: "Paystack PHP SDK",
      items: [
        {
          type: "docSidebar",
          sidebarId: "tutorialSidebar",
          position: "left",
          label: "Documentation",
        },
        {
          href: "https://github.com/matscode/paystack-php-sdk",
          label: "GitHub",
          position: "right",
        },
      ],
    },
    footer: {
      style: "dark",
      links: [
        {
          title: "Docs",
          items: [
            {
              label: "Getting Started",
              to: "/docs/intro",
            },
          ],
        },
        {
          title: "More",
          items: [
            {
              label: "GitHub Repository",
              href: "https://github.com/matscode/paystack-php-sdk",
            },
            {
              label: "API Reference",
              href: "https://matscode.github.io/paystack-php-sdk",
            },
          ],
        },
      ],
      copyright: `Copyright © ${new Date().getFullYear()} Matscode. Built with Docusaurus.`,
    },
    prism: {
      theme: prismThemes.github,
      darkTheme: prismThemes.dracula,
      additionalLanguages: ["php", "bash", "json"],
    },
  } satisfies Preset.ThemeConfig,
};

export default config;
