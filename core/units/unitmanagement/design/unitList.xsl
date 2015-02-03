<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="unitList">
        <xsl:param name="level"/>
        <div class="unit-list">
            <xsl:for-each select="items/item[level=$level]">
                <div class="single-unit"> 
                    <xsl:if test="active=1">
                        <xsl:attribute name="class">
                            single-unit active
                        </xsl:attribute>
                    </xsl:if>
                    <div class="inner">
                        <h2><xsl:value-of select="title" disable-output-escaping="yes"/></h2>
                        <div class="description">
                            <xsl:value-of select="description"/>
                        </div>
                        <div class="class-name">
                            <xsl:value-of select="name"/>
                        </div>
                        <div class="path">
                            <xsl:value-of select="path"/>
                        </div>
                        
                        <div class="dependencies">
                            <xsl:if test="dependencies/item">
                                <div>Dependencies:</div>
                                <xsl:for-each select="dependencies/item">
                                    <span>
                                        <xsl:value-of select="."/>
                                    </span>
                                </xsl:for-each>
                            </xsl:if>
                        </div>
                        <xsl:if test="not(level=1)">
                            <div class="state">
                                <xsl:choose>
                                    <xsl:when test="active=1">
                                        <div class="button disable-unit" data-slug="{slug}"><span/></div>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <div class="button enable-unit" data-slug="{slug}"><span/></div>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </div>
                        </xsl:if>
                    </div>
                </div>
            </xsl:for-each>
        </div>
    </xsl:template>
</xsl:stylesheet>
