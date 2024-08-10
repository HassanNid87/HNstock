@extends('base')

@section('title', 'Home')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9">
            <!-- Carte principale qui englobe tout le contenu -->
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Bienvenue sur la page d'accueil</h1>
                    <p class="card-text">Ce projet est une application de gestion de stock.</p>

                    <!-- Section Tableau de bord -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Tableau de bord</h5>
                            <p class="card-text">Des statistiques et autres informations clés peuvent être affichées ici.</p>
                        </div>
                    </div>

                    <!-- Section avec deux cartes supplémentaires pour les statistiques -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Statistiques des ventes</h5>
                                    <p class="card-text">Ici, vous pouvez afficher des données sur les ventes.</p>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="float-end mt-2" style="position: relative;">
                                                <div id="total-revenue-chart" style="min-height: 40px;"><div id="apexchartsdrh1ixfq" class="apexcharts-canvas apexchartsdrh1ixfq apexcharts-theme-light" style="width: 70px; height: 40px;"><svg id="SvgjsSvg1760" width="70" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1762" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1761"><linearGradient id="SvgjsLinearGradient1766" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1767" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1768" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1769" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskdrh1ixfq"><rect id="SvgjsRect1772" width="74" height="40" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMaskdrh1ixfq"><rect id="SvgjsRect1773" width="74" height="44" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><line id="SvgjsLine1771" x1="65.72727550159802" y1="0" x2="65.72727550159802" y2="40" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="65.72727550159802" y="0" width="1" height="40" fill="url(#SvgjsLinearGradient1766)" filter="none" fill-opacity="0.9" stroke-width="0"></line><g id="SvgjsG1788" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1789" class="apexcharts-xaxis-texts-g" transform="translate(0, 2.75)"></g></g><g id="SvgjsG1791" class="apexcharts-grid"><g id="SvgjsG1792" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1794" x1="0" y1="0" x2="70" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1795" x1="0" y1="8" x2="70" y2="8" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1796" x1="0" y1="16" x2="70" y2="16" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1797" x1="0" y1="24" x2="70" y2="24" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1798" x1="0" y1="32" x2="70" y2="32" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1799" x1="0" y1="40" x2="70" y2="40" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG1793" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1801" x1="0" y1="40" x2="70" y2="40" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1800" x1="0" y1="1" x2="0" y2="40" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1774" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1775" class="apexcharts-series" rel="1" seriesName="seriesx1" data:realIndex="0"><path id="SvgjsPath1777" d="M 1.5909090909090908 40L 1.5909090909090908 30L 4.7727272727272725 30L 4.7727272727272725 30L 4.7727272727272725 40L 4.7727272727272725 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 1.5909090909090908 40L 1.5909090909090908 30L 4.7727272727272725 30L 4.7727272727272725 30L 4.7727272727272725 40L 4.7727272727272725 40z" pathFrom="M 1.5909090909090908 40L 1.5909090909090908 40L 4.7727272727272725 40L 4.7727272727272725 40L 4.7727272727272725 40L 1.5909090909090908 40" cy="30" cx="7.954545454545454" j="0" val="25" barHeight="10" barWidth="3.1818181818181817"></path><path id="SvgjsPath1778" d="M 7.954545454545454 40L 7.954545454545454 13.600000000000001L 11.136363636363637 13.600000000000001L 11.136363636363637 13.600000000000001L 11.136363636363637 40L 11.136363636363637 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 7.954545454545454 40L 7.954545454545454 13.600000000000001L 11.136363636363637 13.600000000000001L 11.136363636363637 13.600000000000001L 11.136363636363637 40L 11.136363636363637 40z" pathFrom="M 7.954545454545454 40L 7.954545454545454 40L 11.136363636363637 40L 11.136363636363637 40L 11.136363636363637 40L 7.954545454545454 40" cy="13.600000000000001" cx="14.318181818181817" j="1" val="66" barHeight="26.4" barWidth="3.1818181818181817"></path><path id="SvgjsPath1779" d="M 14.318181818181817 40L 14.318181818181817 23.6L 17.5 23.6L 17.5 23.6L 17.5 40L 17.5 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 14.318181818181817 40L 14.318181818181817 23.6L 17.5 23.6L 17.5 23.6L 17.5 40L 17.5 40z" pathFrom="M 14.318181818181817 40L 14.318181818181817 40L 17.5 40L 17.5 40L 17.5 40L 14.318181818181817 40" cy="23.6" cx="20.68181818181818" j="2" val="41" barHeight="16.4" barWidth="3.1818181818181817"></path><path id="SvgjsPath1780" d="M 20.68181818181818 40L 20.68181818181818 4.399999999999999L 23.86363636363636 4.399999999999999L 23.86363636363636 4.399999999999999L 23.86363636363636 40L 23.86363636363636 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 20.68181818181818 40L 20.68181818181818 4.399999999999999L 23.86363636363636 4.399999999999999L 23.86363636363636 4.399999999999999L 23.86363636363636 40L 23.86363636363636 40z" pathFrom="M 20.68181818181818 40L 20.68181818181818 40L 23.86363636363636 40L 23.86363636363636 40L 23.86363636363636 40L 20.68181818181818 40" cy="4.399999999999999" cx="27.045454545454543" j="3" val="89" barHeight="35.6" barWidth="3.1818181818181817"></path><path id="SvgjsPath1781" d="M 27.045454545454543 40L 27.045454545454543 14.8L 30.227272727272727 14.8L 30.227272727272727 14.8L 30.227272727272727 40L 30.227272727272727 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 27.045454545454543 40L 27.045454545454543 14.8L 30.227272727272727 14.8L 30.227272727272727 14.8L 30.227272727272727 40L 30.227272727272727 40z" pathFrom="M 27.045454545454543 40L 27.045454545454543 40L 30.227272727272727 40L 30.227272727272727 40L 30.227272727272727 40L 27.045454545454543 40" cy="14.8" cx="33.40909090909091" j="4" val="63" barHeight="25.2" barWidth="3.1818181818181817"></path><path id="SvgjsPath1782" d="M 33.40909090909091 40L 33.40909090909091 30L 36.590909090909086 30L 36.590909090909086 30L 36.590909090909086 40L 36.590909090909086 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 33.40909090909091 40L 33.40909090909091 30L 36.590909090909086 30L 36.590909090909086 30L 36.590909090909086 40L 36.590909090909086 40z" pathFrom="M 33.40909090909091 40L 33.40909090909091 40L 36.590909090909086 40L 36.590909090909086 40L 36.590909090909086 40L 33.40909090909091 40" cy="30" cx="39.772727272727266" j="5" val="25" barHeight="10" barWidth="3.1818181818181817"></path><path id="SvgjsPath1783" d="M 39.772727272727266 40L 39.772727272727266 22.4L 42.954545454545446 22.4L 42.954545454545446 22.4L 42.954545454545446 40L 42.954545454545446 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 39.772727272727266 40L 39.772727272727266 22.4L 42.954545454545446 22.4L 42.954545454545446 22.4L 42.954545454545446 40L 42.954545454545446 40z" pathFrom="M 39.772727272727266 40L 39.772727272727266 40L 42.954545454545446 40L 42.954545454545446 40L 42.954545454545446 40L 39.772727272727266 40" cy="22.4" cx="46.136363636363626" j="6" val="44" barHeight="17.6" barWidth="3.1818181818181817"></path><path id="SvgjsPath1784" d="M 46.136363636363626 40L 46.136363636363626 32L 49.318181818181806 32L 49.318181818181806 32L 49.318181818181806 40L 49.318181818181806 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 46.136363636363626 40L 46.136363636363626 32L 49.318181818181806 32L 49.318181818181806 32L 49.318181818181806 40L 49.318181818181806 40z" pathFrom="M 46.136363636363626 40L 46.136363636363626 40L 49.318181818181806 40L 49.318181818181806 40L 49.318181818181806 40L 46.136363636363626 40" cy="32" cx="52.499999999999986" j="7" val="20" barHeight="8" barWidth="3.1818181818181817"></path><path id="SvgjsPath1785" d="M 52.499999999999986 40L 52.499999999999986 25.6L 55.681818181818166 25.6L 55.681818181818166 25.6L 55.681818181818166 40L 55.681818181818166 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 52.499999999999986 40L 52.499999999999986 25.6L 55.681818181818166 25.6L 55.681818181818166 25.6L 55.681818181818166 40L 55.681818181818166 40z" pathFrom="M 52.499999999999986 40L 52.499999999999986 40L 55.681818181818166 40L 55.681818181818166 40L 55.681818181818166 40L 52.499999999999986 40" cy="25.6" cx="58.863636363636346" j="8" val="36" barHeight="14.4" barWidth="3.1818181818181817"></path><path id="SvgjsPath1786" d="M 58.863636363636346 40L 58.863636363636346 24L 62.045454545454525 24L 62.045454545454525 24L 62.045454545454525 40L 62.045454545454525 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 58.863636363636346 40L 58.863636363636346 24L 62.045454545454525 24L 62.045454545454525 24L 62.045454545454525 40L 62.045454545454525 40z" pathFrom="M 58.863636363636346 40L 58.863636363636346 40L 62.045454545454525 40L 62.045454545454525 40L 62.045454545454525 40L 58.863636363636346 40" cy="24" cx="65.2272727272727" j="9" val="40" barHeight="16" barWidth="3.1818181818181817"></path><path id="SvgjsPath1787" d="M 65.2272727272727 40L 65.2272727272727 18.4L 68.40909090909089 18.4L 68.40909090909089 18.4L 68.40909090909089 40L 68.40909090909089 40z" fill="rgba(91,115,232,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskdrh1ixfq)" pathTo="M 65.2272727272727 40L 65.2272727272727 18.4L 68.40909090909089 18.4L 68.40909090909089 18.4L 68.40909090909089 40L 68.40909090909089 40z" pathFrom="M 65.2272727272727 40L 65.2272727272727 40L 68.40909090909089 40L 68.40909090909089 40L 68.40909090909089 40L 65.2272727272727 40" cy="18.4" cx="71.59090909090907" j="10" val="54" barHeight="21.6" barWidth="3.1818181818181817"></path></g><g id="SvgjsG1776" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1802" x1="0" y1="0" x2="70" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1803" x1="0" y1="0" x2="70" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1804" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1805" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1806" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1770" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1790" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1763" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 20px;"></div><div class="apexcharts-tooltip apexcharts-theme-light" style="left: 24.821px; top: 5px;"><div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgba(91, 115, 232, 0.85); display: none;"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value">54</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 71px; height: 41px;"></div></div><div class="contract-trigger"></div></div></div>
                                            <div>
                                                <h4 class="mb-1 mt-1">$<span data-plugin="counterup">34,152</span></h4>
                                                <p class="text-muted mb-0">Total Revenue</p>
                                            </div>
                                            <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Inventaire actuel</h5>
                                    <p class="card-text">Affichez les informations sur l'inventaire.</p>
                                    <!-- Insérer un graphique ou un tableau ici -->
                                </div>
                            </div><div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" style="">
                                                <a class="dropdown-item" href="#">Monthly</a>
                                                <a class="dropdown-item" href="#">Yearly</a>
                                                <a class="dropdown-item" href="#">Weekly</a>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">Top Selling Products</h4>


                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> Desktops </p>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="52">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> iPhones </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success me-2"></i> Android </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-success" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="48">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> Tablets </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-warning" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                    <div class="row align-items-center g-0 mt-3">
                                        <div class="col-sm-3">
                                            <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> Cables </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar progress-bar bg-purple" role="progressbar" style="width: 63%" aria-valuenow="63" aria-valuemin="0" aria-valuemax="63">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->

                                </div> <!-- end card-body-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
