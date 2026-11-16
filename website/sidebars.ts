import type { SidebarsConfig } from "@docusaurus/plugin-content-docs";

const sidebars: SidebarsConfig = {
  tutorialSidebar: [
    "intro",
    {
      type: "category",
      label: "Core Resources",
      collapsed: false,
      items: [
        "resources/transaction",
        "resources/plan",
        "resources/subscription",
      ],
    },
    {
      type: "category",
      label: "Miscellaneous",
      collapsed: false,
      items: [
        "resources/miscellaneous/bank",
        "resources/miscellaneous/card",
        "resources/miscellaneous/country",
      ],
    },
  ],
};

export default sidebars;
