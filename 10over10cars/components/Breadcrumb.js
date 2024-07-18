"use client";
import React from "react";
import { useRouter } from "next/navigation";

const Breadcrumb = ({ currentUrl }) => {
  const router = useRouter();
  const path = router.asPath;

  // Split the path into segments and filter out empty strings
  const pathSegments = currentUrl.split("/").filter((segment) => segment);

  return (
    <nav className={styles.breadcrumb}>
      <ol>
        <li>
          <a href="/">Home</a>
        </li>
        {pathSegments.map((segment, index) => (
          <li key={index}>{segment}</li>
        ))}
      </ol>
    </nav>
  );
};

export default Breadcrumb;
