import React, { lazy } from "react";

const HomeBack = lazy(() => import("../pages/home/HomeBack"));
const ProductType = lazy(() => import("../pages/home/ProductType"));

const routes = [
  {
    path: "/",
    element: <HomeBack />
  },
  {
    path: "/product-info",
    element: <ProductType/>
  }
];

export default routes;